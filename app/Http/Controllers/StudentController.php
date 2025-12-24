<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public $menu_url = "students";
    public $data = [];

    public function index(Request $request)
    {
        $schoolId = $request->get('school_id');
        $studentsCount = Student::count();
        $grade = $request->get('grade');
        $gender = $request->get('gender');
        $participateWith = $request->get('participate_with');

        $query = Student::with('school');

        if ($schoolId) {
            $query->where('school_id', $schoolId);
        }

        if ($grade) {
            $query->where('grade', $grade);
        }

        if ($gender) {
            $query->where('gender', $gender);
        }

        if ($participateWith) {
            $query->where('participate_with', $participateWith);
        }

        $this->data['students'] = $query->orderBy('roll_number', 'asc')->get();
        $this->data['school_student_count'] = $query->orderBy('roll_number', 'asc')->count();
        $this->data['schools'] = School::orderBy('school_name', 'asc')->get();
        $this->data['selected_school_id'] = $request->get('school_id');
        $this->data['selected_school'] = $schoolId ? School::find($schoolId) : null;
        $this->data['student_count'] = $studentsCount;
        $this->data['menu'] = "students_list";
        return view('students.list', $this->data);
    }

    public function create(Request $request)
    {
        // $this->data['schools'] = School::all();
        $this->data['schools'] = School::orderBy('school_name', 'asc')->get();
        $this->data['selected_school_id'] = $request->get('school_id');
        $this->data['menu'] = "add_student";
        return view('students.create', $this->data);
    }

    public function createIndividual(Request $request)
    {
        $this->data['schools'] = School::all();
        $this->data['selected_school_id'] = $request->get('school_id');
        $this->data['menu'] = "add_student";
        return view('students.create-individual-layout', $this->data);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:191',
            'father' => 'required|string|max:191',
            'dob' => 'required|date',
            'age' => 'required|integer',
            'grade' => 'required|in:5,8',
            'gender' => 'required|in:male,female',
            'contact' => 'required|tel',
            'school' => 'required|exists:schools,id',
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

        // Generate roll number
        $rollNumber = $this->generateRollNumber($request->gender);

        // Ensure uniqueness in case of concurrent requests
        while (Student::where('roll_number', $rollNumber)->exists()) {
            $rollNumber = $this->incrementRollNumber($rollNumber);
        }

        $studentData = [
            'name' => $request->name,
            'father' => $request->father,
            'dob' => $request->dob,
            'grade' => $request->grade,
            'gender' => $request->gender,
            'participate_with' => 'school',
            'roll_number' => $rollNumber,
            'school_id' => $request->school_id,
        ];

        $student = Student::create($studentData);

        if ($request->expectsJson()) {
            return response()->json([
                'status' => true,
                'message' => "Student {$student->name} created successfully with Roll Number: {$student->roll_number}",
                'data' => $student,
            ]);
        } else {
            return redirect()->back()->with('success', "Student {$student->name} created successfully with Roll Number: {$student->roll_number}");
        }
    }

    public function storeIndividual(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:191',
            'father' => 'required|string|max:191',
            'dob' => 'required|date',
            'grade' => 'required|in:5,8',
            'gender' => 'required|in:male,female',
            'school_name' => 'required|string|max:191',
            'contact' => 'required|string|max:191',
            'payment_receipt_individual' => 'required|image|mimes:jpg,jpeg,png|max:3072',
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

        // Generate roll number
        $rollNumber = $this->generateRollNumber($request->grade, $request->gender);

        // Ensure uniqueness in case of concurrent requests
        while (Student::where('roll_number', $rollNumber)->exists()) {
            $rollNumber = $this->incrementRollNumber($rollNumber);
        }

        // Handle receipt upload
        $receiptPath = null;
        if ($request->hasFile('payment_receipt_individual')) {
            $file = $request->file('payment_receipt_individual');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('receipts/individual'), $filename);
            $receiptPath = 'receipts/individual/' . $filename;
        }

        $studentData = [
            'name' => $request->name,
            'father' => $request->father,
            'dob' => $request->dob,
            'grade' => $request->grade,
            'gender' => $request->gender,
            'participate_with' => 'individual',
            'roll_number' => $rollNumber,
            'school_name' => $request->school_name,
            'contact' => $request->contact,
            'payment_receipt_individual' => $receiptPath,
        ];

        $student = Student::create($studentData);

        if ($request->expectsJson()) {
            return response()->json([
                'status' => true,
                'message' => "Individual Student {$student->name} created successfully with Roll Number: {$student->roll_number}",
                'data' => $student,
            ]);
        } else {
            return redirect()->back()->with('success', "Individual Student {$student->name} created successfully with Roll Number: {$student->roll_number}");
        }
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        if ($student->participate_with === 'school') {
            $this->data['student'] = $student;
            $this->data['schools'] = School::all();
            $this->data['menu'] = "students_list";
            return view('students.edit-layout', $this->data);
        } else {
            return redirect()->route('students.edit-individual', $id);
        }
    }

    public function editIndividual($id)
    {
        $this->data['student'] = Student::findOrFail($id);
        $this->data['schools'] = School::all();
        $this->data['menu'] = "students_list";
        return view('students.edit-individual-layout', $this->data);
    }

    public function update(Request $request)
    {
        $rules = [
            'id' => 'required|exists:students,id',
            'name' => 'required|string|max:191',
            'father' => 'required|string|max:191',
            'dob' => 'required|date',
            'grade' => 'required|in:5,8',
            'gender' => 'required|in:male,female',
            'participate_with' => 'required|in:school,individual',
        ];

        if ($request->participate_with === 'school') {
            $rules['school_id'] = 'required|exists:schools,id';
        } else {
            $rules['school_name'] = 'required|string|max:191';
            $rules['contact'] = 'required|string|max:191';
            $rules['payment_receipt_individual'] = 'nullable|image|mimes:jpg,jpeg,png|max:3072';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $student = Student::findOrFail($request->id);

        // Check if grade or gender changed, regenerate roll number if needed
        $newRollNumber = $this->generateRollNumber($request->grade, $request->gender);
        if ($student->roll_number != $newRollNumber) {
            // Ensure uniqueness
            while (Student::where('roll_number', $newRollNumber)->where('id', '!=', $student->id)->exists()) {
                $newRollNumber = $this->incrementRollNumber($newRollNumber);
            }
        }

        // Handle receipt upload for individual (replace if new one uploaded)
        $receiptPath = $student->payment_receipt_individual;
        if ($request->participate_with === 'individual' && $request->hasFile('payment_receipt_individual')) {
            // Delete old file if exists
            if ($receiptPath && File::exists(public_path($receiptPath))) {
                File::delete(public_path($receiptPath));
            }
            $file = $request->file('payment_receipt_individual');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('receipts/individual'), $filename);
            $receiptPath = 'receipts/individual/' . $filename;
        }

        $updateData = [
            'name' => $request->name,
            'father' => $request->father,
            'dob' => $request->dob,
            'grade' => $request->grade,
            'gender' => $request->gender,
            'participate_with' => $request->participate_with,
            'roll_number' => $newRollNumber,
        ];

        if ($request->participate_with === 'school') {
            $updateData['school_id'] = $request->school_id;
            $updateData['school_name'] = null;
            $updateData['contact'] = null;
            $updateData['payment_receipt_individual'] = null;
        } else {
            $updateData['school_id'] = null;
            $updateData['school_name'] = $request->school_name;
            $updateData['contact'] = $request->contact;
            $updateData['payment_receipt_individual'] = $receiptPath;
        }

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
        if ($student->payment_receipt_individual && File::exists(public_path($student->payment_receipt_individual))) {
            File::delete(public_path($student->payment_receipt_individual));
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
    private function generateRollNumber()
    {
        $baseNumbers = 12201;



        // Lock the table to avoid concurrent roll number collisions
        return \DB::transaction(function () use ($baseNumbers) {
            $maxRoll = Student::max('roll_number');

            return $maxRoll ? $maxRoll + 1 : $baseNumbers;
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
        $schoolId = $request->input('school_id');
        $grade = $request->input('grade');
        $gender = $request->input('gender');
        $participateWith = $request->input('participate_with');

        $query = Student::with(['school']);

        if ($schoolId) {
            $query->where('school_id', $schoolId);
        }

        if ($grade) {
            $query->where('grade', (string) $grade);
        }

        if ($gender) {
            $query->where('gender', $gender);
        }

        if ($participateWith) {
            $query->where('participate_with', $participateWith);
        }

        $students = $query->orderBy("roll_number", "ASC")->get();

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
        $schoolId = $request->input('school_id');

        $query = Student::with('school');

        if ($schoolId) {
            $query->where('school_id', $schoolId);
        }

        // Order by grade and gender as specified: 5th boys, 5th girls, 8th boys, 8th girls
        $students = $query->orderByRaw("
            CASE
                WHEN grade = 5 AND gender = 'male' THEN 1
                WHEN grade = 5 AND gender = 'female' THEN 2
                WHEN grade = 8 AND gender = 'male' THEN 3
                WHEN grade = 8 AND gender = 'female' THEN 4
                ELSE 5
            END
        ")->orderBy("roll_number", "ASC")->get();

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
        $filename = 'roll_slip_' . $student->roll_number . '_' . date('ymdhis');

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
        $filename = 'roll_slip_' . $student->roll_number . '_' . date('ymdhis');

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
        $filename = 'roll_slip_' . $student->roll_number . '_' . date('ymdhis');

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

    public function rebuildRollNumbers()
    {
        $baseNumbers = [
            '5_male' => 11201,
            '5_female' => 12201,
            '8_male' => 13201,
            '8_female' => 14201,
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

                $roll = $baseNumbers[$key];
                foreach ($group as $student) {
                    $student->update(['roll_number' => $roll]);
                    $roll++;
                }
            }
        });

        return response()->json([
            'status' => true,
            'message' => 'All roll numbers rebuilt successfully.'
        ]);
    }


}
