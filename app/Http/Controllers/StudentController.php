<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public $menu_url = "students";
    public $data = [];

    public function index(Request $request)
    {
        // Check if user is admin
        if (session()->get('role')->code !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $studentsCount = Student::count();
        $grade = $request->get('grade');

        $query = Student::query();

        if ($grade) {
            $query->where('grade', $grade);
        }

        $this->data['students'] = $query->orderBy('participation_id', 'asc')->get();
        $this->data['school_student_count'] = $query->orderBy('participation_id', 'asc')->count();
        $this->data['student_count'] = $studentsCount;
        $this->data['menu'] = "students_list";
        return view('students.list', $this->data);
    }

    public function create(Request $request)
    {
        $this->data['menu'] = "add_student";
        $this->data['is_admin'] = session()->get('role')->code == 'admin';
        return view('students.create-layout', $this->data);
    }

    public function store(Request $request)
    {
        $rules = [
            'school_name' => 'nullable|string|max:191',
            'name' => 'required|string|max:191',
            'father' => 'required|string|max:191',
            'dob' => 'required|date',
            'age' => 'required|integer',
            'gender' => 'required|in:male',
            'grade' => 'required|in:8,9,10',
            'contact' => 'nullable|string|max:191',
            'payment_receipt' => 'required|image|mimes:jpg,jpeg,png|max:3072',
            'student_image' => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first()
                ]);
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        // Generate participation id
        $participationId = $this->generateParticipationId();

        // Ensure uniqueness in case of concurrent requests
        while (Student::where('participation_id', $participationId)->exists()) {
            $participationId++;
        }

        // Handle receipt upload
        $receiptPath = null;
        if ($request->hasFile('payment_receipt')) {
            $receiptDir = public_path('receipts');
            if (!is_dir($receiptDir)) {
                if (!mkdir($receiptDir, 0777, true)) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Failed to create receipts directory.'
                    ]);
                }
            }
            if (!is_writable($receiptDir)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Receipts directory is not writable.'
                ]);
            }
            $file = $request->file('payment_receipt');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            if ($file->move($receiptDir, $filename)) {
                $receiptPath = 'receipts/' . $filename;
            } else {
                Log::error('Payment receipt upload failed in update: filename ' . $filename . ', dir ' . $receiptDir);
                return response()->json([
                    'status' => false,
                    'message' => 'The payment receipt failed to upload.'
                ]);
            }
        }

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('student_image')) {
            $imageDir = public_path('images/students');
            if (!is_dir($imageDir)) {
                if (!mkdir($imageDir, 0777, true)) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Failed to create images directory.'
                    ]);
                }
            }
            if (!is_writable($imageDir)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Images directory is not writable.'
                ]);
            }
            $file = $request->file('student_image');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            if ($file->move($imageDir, $filename)) {
                $imagePath = 'images/students/' . $filename;
            } else {
                Log::error('Student image upload failed in update: filename ' . $filename . ', dir ' . $imageDir);
                return response()->json([
                    'status' => false,
                    'message' => 'The student image failed to upload.'
                ]);
            }
        }

        $studentData = [
            'school_name' => $request->school_name,
            'name' => $request->name,
            'father' => $request->father,
            'dob' => $request->dob,
            'age' => $request->age,
            'grade' => $request->grade,
            'gender' => $request->gender,
            'participation_id' => $participationId,
            'contact' => $request->contact,
            'payment_receipt' => $receiptPath,
            'student_image' => $imagePath,
        ];

        $student = Student::create($studentData);

        // Generate participation slip PDF
        $filename = 'participation_slip_' . $student->participation_id . '_' . date('ymdhis') . '.pdf';
        $pdf = Pdf::loadView('students.single-roll-slip-template', ['student' => $student]);
        $pdf->setPaper('A4', 'portrait');

        // Ensure downloads directory exists
        $downloadsDir = public_path('downloads');
        if (!is_dir($downloadsDir)) {
            mkdir($downloadsDir, 0777, true);
        }

        $filePath = public_path('downloads/' . $filename);
        $pdf->save($filePath);

        if ($request->expectsJson()) {
            return response()->json([
                'status' => true,
                'message' => "Student {$student->name} created successfully with Participation ID: {$student->participation_id}",
                'data' => $student,
                'download_url' => asset('downloads/' . $filename),
            ]);
        } else {
            // Return PDF for download
            return $pdf->download($filename);
        }
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $this->data['student'] = $student;
        $this->data['menu'] = "students_list";
        return view('students.edit-layout', $this->data);
    }

    public function update(Request $request)
    {
        $rules = [
            'id' => 'required|exists:students,id',
            'school_name' => 'nullable|string|max:191',
            'name' => 'required|string|max:191',
            'father' => 'required|string|max:191',
            'dob' => 'required|date',
            'age' => 'required|integer',
            'grade' => 'required|in:8,9,10',
            'gender' => 'required|in:male',
            'contact' => 'nullable|string|max:191',
            'payment_receipt' => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
            'student_image' => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $student = Student::findOrFail($request->id);

        // Handle receipt upload (replace if new one uploaded)
        $receiptPath = $student->payment_receipt;
        if ($request->hasFile('payment_receipt')) {
            // Delete old file if exists
            if ($receiptPath && File::exists(public_path($receiptPath))) {
                File::delete(public_path($receiptPath));
            }
            $receiptDir = public_path('receipts');
            if (!is_dir($receiptDir)) {
                if (!mkdir($receiptDir, 0777, true)) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Failed to create receipts directory.'
                    ]);
                }
            }
            if (!is_writable($receiptDir)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Receipts directory is not writable.'
                ]);
            }
            $file = $request->file('payment_receipt');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            if ($file->move($receiptDir, $filename)) {
                $receiptPath = 'receipts/' . $filename;
            } else {
                Log::error('Payment receipt upload failed in store: filename ' . $filename . ', dir ' . $receiptDir);
                return response()->json([
                    'status' => false,
                    'message' => 'The payment receipt failed to upload.'
                ]);
            }
        }

        // Handle image upload (replace if new one uploaded)
        $imagePath = $student->student_image;
        if ($request->hasFile('student_image')) {
            // Delete old file if exists
            if ($imagePath && File::exists(public_path($imagePath))) {
                File::delete(public_path($imagePath));
            }
            $imageDir = public_path('images/students');
            if (!is_dir($imageDir)) {
                if (!mkdir($imageDir, 0777, true)) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Failed to create images directory.'
                    ]);
                }
            }
            if (!is_writable($imageDir)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Images directory is not writable.'
                ]);
            }
            $file = $request->file('student_image');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            if ($file->move($imageDir, $filename)) {
                $imagePath = 'images/students/' . $filename;
            } else {
                Log::error('Student image upload failed in store: filename ' . $filename . ', dir ' . $imageDir);
                return response()->json([
                    'status' => false,
                    'message' => 'The student image failed to upload.'
                ]);
            }
        }

        $updateData = [
            'school_name' => $request->school_name,
            'name' => $request->name,
            'father' => $request->father,
            'dob' => $request->dob,
            'age' => $request->age,
            'grade' => $request->grade,
            'gender' => $request->gender,
            'contact' => $request->contact,
            'payment_receipt' => $receiptPath,
            'student_image' => $imagePath,
        ];

        $student->update($updateData);

        return response()->json([
            'status' => true,
            'message' => 'Student updated successfully',
            'data' => $student,
        ]);
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:students,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $student = Student::find($request->id);

        // Delete receipt file if exists
        if ($student->payment_receipt && File::exists(public_path($student->payment_receipt))) {
            File::delete(public_path($student->payment_receipt));
        }

        // Delete image file if exists
        if ($student->student_image && File::exists(public_path($student->student_image))) {
            File::delete(public_path($student->student_image));
        }

        $student->delete();

        return response()->json([
            'status' => true,
            'message' => 'Student deleted successfully'
        ]);
    }

    // private function generateRollNumber($grade, $gender)
    // {
    //     $baseNumbers = [
    //         '5_male' => 11201,
    //         '5_female' => 12201,
    //         '8_male' => 13201,
    //         '8_female' => 14201,
    //     ];

    //     $key = $grade . '_' . $gender;
    //     $base = $baseNumbers[$key];

    //     // Find the next available roll number, including soft deleted to avoid reusing deleted roll numbers
    //     $existing = Student::withTrashed()->where('roll_number', 'like', substr($base, 0, 3) . '%')
    //         ->orderBy('roll_number', 'desc')
    //         ->first();

    //     if ($existing) {
    //         $lastNumber = (int) substr($existing->roll_number, 3);
    //         return substr($base, 0, 3) . str_pad($lastNumber + 1, 2, '0', STR_PAD_LEFT);
    //     }

    //     return $base;
    // }
    private function generateParticipationId()
    {
        $baseNumbers = 10001;

        // Lock the table to avoid concurrent participation id collisions
        return \DB::transaction(function () use ($baseNumbers) {
            $maxId = Student::max('participation_id');

            return $maxId ? $maxId + 1 : $baseNumbers;
        });
    }



    private function incrementRollNumber($rollNumber)
    {
        $prefix = substr($rollNumber, 0, 3);
        $number = (int) substr($rollNumber, 3) + 1;
        return $prefix . str_pad($number, 2, '0', STR_PAD_LEFT);
    }

    public function downloadPdf(Request $request)
    {
        $grade = $request->input('grade');
        $gender = $request->input('gender');

        $query = Student::query();

        if ($grade) {
            $query->where('grade', (string) $grade);
        }

        if ($gender) {
            $query->where('gender', $gender);
        }

        $students = $query->orderBy("participation_id", "ASC")->get();

        if ($students->count() < 1) {
            return response()->json([
                'status' => false,
                'message' => "No record found"
            ]);
        }

        // Generate a unique filename
        $filename = date('ymdhis');

        // Load the PDF view
        $pdf = Pdf::loadView('students.download-template', [
            'students' => $students
        ]);

        // Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');

        // Ensure downloads directory exists
        $downloadsDir = public_path('downloads');
        if (!is_dir($downloadsDir)) {
            if (!mkdir($downloadsDir, 0777, true)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to create downloads directory.'
                ]);
            }
        }

        // Ensure downloads directory exists
        $downloadsDir = public_path('downloads');
        if (!is_dir($downloadsDir)) {
            if (!mkdir($downloadsDir, 0777, true)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to create downloads directory.'
                ]);
            }
        }

        // Ensure downloads directory exists
        $downloadsDir = public_path('downloads');
        if (!is_dir($downloadsDir)) {
            if (!mkdir($downloadsDir, 0777, true)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to create downloads directory.'
                ]);
            }
        }

        // Save the PDF to public/downloads
        $pdf->save(public_path() . '/downloads/' . $filename . '.pdf');

        $open_path = asset("downloads") . '/' . $filename . '.pdf?v=' . date('ymdhis');

        return response()->json([
            'status' => true,
            'download_path' => $open_path
        ]);
    }

    public function downloadRollSlips(Request $request)
    {
        $query = Student::query();

        // Order by grade: 8th, 9th, 10th
        $students = $query->orderByRaw("
            CASE
                WHEN grade = 8 THEN 1
                WHEN grade = 9 THEN 2
                WHEN grade = 10 THEN 3
                ELSE 4
            END
        ")->orderBy("participation_id", "ASC")->get();

        if ($students->count() < 1) {
            return response()->json([
                'status' => false,
                'message' => "No students found for this school"
            ]);
        }

        // Generate a unique filename
        $filename = 'roll_slips_' . date('ymdhis');

        // Load the PDF view for roll slips
        $pdf = Pdf::loadView('students.roll-slip-template', [
            'students' => $students
        ]);

        // Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');

        // Save the PDF to public/downloads
        $pdf->save(public_path() . '/downloads/' . $filename . '.pdf');

        $open_path = asset("downloads") . '/' . $filename . '.pdf?v=' . date('ymdhis');

        return response()->json([
            'status' => true,
            'download_path' => $open_path
        ]);
    }

    public function downloadRollSlipIndividual(Request $request)
    {
        $studentId = $request->input('student_id');

        $student = Student::findOrFail($studentId);

        // Only allow for individual students
        if ($student->participate_with !== 'individual') {
            return response()->json([
                'status' => false,
                'message' => "This feature is only available for individual students"
            ]);
        }

        // Generate a unique filename
        $filename = 'roll_slip_' . $student->participation_id . '_' . date('ymdhis');

        // Load the PDF view for individual roll slip
        $pdf = Pdf::loadView('students.roll-slip-template', [
            'students' => collect([$student]) // Pass as collection with single student
        ]);

        // Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');

        // Save the PDF to public/downloads
        $pdf->save(public_path() . '/downloads/' . $filename . '.pdf');

        $open_path = asset("downloads") . '/' . $filename . '.pdf?v=' . date('ymdhis');

        return response()->json([
            'status' => true,
            'download_path' => $open_path
        ]);
    }

    public function downloadRollSlip(Request $request)
    {
        $studentId = $request->input('student_id');

        $student = Student::findOrFail($studentId);

        // Generate a unique filename
        $filename = 'roll_slip_' . $student->participation_id . '_' . date('ymdhis');

        // Load the PDF view for roll slip
        $pdf = Pdf::loadView('students.roll-slip-template', [
            'students' => collect([$student]) // Pass as collection with single student
        ]);

        // Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');

        // Save the PDF to public/downloads
        $pdf->save(public_path() . '/downloads/' . $filename . '.pdf');

        $open_path = asset("downloads") . '/' . $filename . '.pdf?v=' . date('ymdhis');

        return response()->json([
            'status' => true,
            'download_path' => $open_path
        ]);
    }

    public function downloadSingleRollSlip(Request $request)
    {
        $studentId = $request->input('student_id');

        $student = Student::findOrFail($studentId);

        // Generate a unique filename
        $safeName = str_replace(' ', '_', $student->name);
        $year = \Carbon\Carbon::parse($student->dob)->year;
        $filename = $safeName . '-' . $year;

        // Load the PDF view for single roll slip
        $pdf = Pdf::loadView('students.single-roll-slip-template', [
            'student' => $student
        ]);

        // Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');

        // Save the PDF to public/downloads
        $pdf->save(public_path() . '/downloads/' . $filename . '.pdf');

        $open_path = asset("downloads") . '/' . $filename . '.pdf?v=' . date('ymdhis');

        return response()->json([
            'status' => true,
            'download_path' => $open_path
        ]);
    }

    public function rebuildParticipationIds()
    {
        $baseNumbers = [
            '8_male' => 13201,
            '8_female' => 14201,
            '9_male' => 15201,
            '9_female' => 16201,
            '10_male' => 17201,
            '10_female' => 18201,
        ];

        // Get all non-deleted students, order deterministically
        $students = Student::whereNull('deleted_at')
            ->orderBy('grade')
            ->orderBy('gender')
            ->orderBy('id')
            ->get();

        $groups = $students->groupBy(fn($s) => $s->grade . '_' . $s->gender);

        \DB::transaction(function () use ($groups, $baseNumbers) {
            foreach ($groups as $key => $group) {
                if (!isset($baseNumbers[$key]))
                    continue;

                $id = $baseNumbers[$key];
                foreach ($group as $student) {
                    $student->update(['participation_id' => $id]);
                    $id++;
                }
            }
        });

        return response()->json([
            'status' => true,
            'message' => 'All participation ids rebuilt successfully.'
        ]);
    }


}
