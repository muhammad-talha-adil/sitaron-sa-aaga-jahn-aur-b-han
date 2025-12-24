<?php

namespace App\Http\Controllers;

use App\Helpers\FileUploadHelper;
use App\Helpers\SiteHelper;
use App\Models\Participant;
use App\Models\Role;
use App\Models\School;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SchoolController extends Controller
{
    public $menu_url = "schools";
    public $data = [];

    public function index(Request $request)
    {
        $this->data['schools'] = School::with(['participants', 'students'])->latest()->get();
        $this->data['menu'] = "schools_list";
        $this->data['school_count'] = School::count();
        return view('schools.list', $this->data);
    }

    public function create()
    {
        $this->data['menu'] = "add_school";
        return view('schools.create', $this->data);
    }

//    public function store(Request $request)
// {
//     $validator = Validator::make($request->all(), [
//         'school_name'      => 'required|max:191',
//         'address'          => 'required|max:191',
//         'owner_name'       => 'required|max:191',
//         'phone'            => 'required|numeric',
//         'purpose_of_visit' => 'required|in:Visit Only,Participation',

//         // Conditional fields
//         'total_visitors'   => 'required_if:purpose_of_visit,Visit Only|nullable|numeric|min:1',
//         'incharge_name'    => 'required_if:purpose_of_visit,Participation|max:191|nullable',
//         'incharge_phone'   => 'required_if:purpose_of_visit,Participation|numeric|nullable',
//         'modal_girls'      => 'required_if:purpose_of_visit,Participation|numeric|nullable|min:0',
//         'modal_boys'       => 'required_if:purpose_of_visit,Participation|numeric|nullable|min:0',
//     ]);

//     if ($validator->fails()) {
//         return response()->json([
//             'status'  => false,
//             'message' => $validator->errors()->first()
//         ]);
//     }

//     // Create the school record
//     $school = School::create([
//         'school_name'      => $request->school_name,
//         'address'          => $request->address,
//         'owner_name'       => $request->owner_name,
//         'phone'            => $request->phone,
//         'purpose_of_visit' => $request->purpose_of_visit,
//         'total_visitors'   => $request->total_visitors ?? null,
//         'incharge_name'    => $request->incharge_name ?? null,
//         'incharge_phone'   => $request->incharge_phone ?? null,
//         'modal_girls'      => $request->modal_girls ?? null,
//         'modal_boys'       => $request->modal_boys ?? null,
//     ]);

//     return response()->json([
//         'status'  => true,
//         'message' => 'School saved successfully',
//         'data'    => $school,
//     ]);
// }


public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'school_name'     => 'required|max:191',
        'address'         => 'required|max:191',
        'owner_name'      => 'required|max:191',
        'phone'           => 'required|numeric',
        'payment_receipt' => 'required|image|mimes:jpg,jpeg,png|max:3072',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status'  => false,
            'message' => $validator->errors()->first()
        ]);
    }

    // Handle receipt upload
    $receiptPath = null;
    if ($request->hasFile('payment_receipt')) {
        $file = $request->file('payment_receipt');
        $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('receipts'), $filename);
        $receiptPath = 'receipts/' . $filename;
    }

    // Create the school record
    $school = School::create([
        'school_name'     => $request->school_name,
        'address'         => $request->address,
        'owner_name'      => $request->owner_name,
        'phone'           => $request->phone,
        'payment_receipt' => $receiptPath,
    ]);

    return response()->json([
        'status'  => true,
        'message' => 'School saved successfully',
        'data'    => $school,
    ]);
}


public function update(Request $request)
{
    $validator = Validator::make($request->all(), [
        'id'              => 'required|exists:schools,id',
        'school_name'     => 'required|max:191',
        'address'         => 'required|max:191',
        'owner_name'      => 'required|max:191',
        'phone'           => 'required|numeric',
        'payment_receipt' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status'  => false,
            'message' => $validator->errors()->first()
        ]);
    }

    $school = School::findOrFail($request->id);

    // Handle receipt upload (replace if new one uploaded)
    $receiptPath = $school->payment_receipt;
    if ($request->hasFile('payment_receipt')) {
        // Delete old file if exists
        if ($receiptPath && File::exists(public_path($receiptPath))) {
            File::delete(public_path($receiptPath));
        }
        $file = $request->file('payment_receipt');
        $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('receipts'), $filename);
        $receiptPath = 'receipts/' . $filename;
    }

    $school->update([
        'school_name'     => $request->school_name,
        'address'         => $request->address,
        'owner_name'      => $request->owner_name,
        'phone'           => $request->phone,
        'payment_receipt' => $receiptPath,
    ]);

    return response()->json([
        'status'  => true,
        'message' => 'School updated successfully',
        'data'    => $school,
    ]);
}

    public function edit($id)
    {
        $this->data['school'] = School::findOrFail($id);
        $this->data['menu'] = "schools_list";
        return view('schools.edit', $this->data);
    }

//  public function update(Request $request)
// {
//     $validator = Validator::make($request->all(), [
//         'id'               => 'required|exists:schools,id',
//         'school_name'      => 'required|max:191',
//         'address'          => 'required|max:191',
//         'owner_name'       => 'required|max:191',
//         'phone'            => 'required|numeric',
//         'purpose_of_visit' => 'required|in:Visit Only,Participation',

//         // Conditional fields
//         'total_visitors'   => 'required_if:purpose_of_visit,Visit Only|nullable|numeric|min:1',
//         'incharge_name'    => 'required_if:purpose_of_visit,Participation|max:191|nullable',
//         'incharge_phone'   => 'required_if:purpose_of_visit,Participation|numeric|nullable',
//         'modal_girls'      => 'required_if:purpose_of_visit,Participation|numeric|nullable|min:0',
//         'modal_boys'       => 'required_if:purpose_of_visit,Participation|numeric|nullable|min:0',
//     ]);

//     if ($validator->fails()) {
//         return response()->json([
//             'status'  => false,
//             'message' => $validator->errors()->first()
//         ]);
//     }

//     // Update the school record
//     $school = School::where('id', $request->id)->first();
//     $school->update([
//         'school_name'      => $request->school_name,
//         'address'          => $request->address,
//         'owner_name'       => $request->owner_name,
//         'phone'            => $request->phone,
//         'purpose_of_visit' => $request->purpose_of_visit,
//         'total_visitors'   => $request->total_visitors ?? null,
//         'incharge_name'    => $request->incharge_name ?? null,
//         'incharge_phone'   => $request->incharge_phone ?? null,
//         'modal_girls'      => $request->modal_girls ?? null,
//         'modal_boys'       => $request->modal_boys ?? null,
//     ]);

//     return response()->json([
//         'status'  => true,
//         'message' => 'School updated successfully',
//         'data'    => $school,
//     ]);
// }



    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:schools,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $School = School::find($request->id);

        if (!$School) {
            return response()->json([
                'status' => false,
                'message' => 'School not found'
            ]);
        }

        // Delete receipt file if exists
        if ($School->payment_receipt && File::exists(public_path($School->payment_receipt))) {
            File::delete(public_path($School->payment_receipt));
        }

        $School->delete();

        return response()->json([
            'status' => true,
            'message' => 'School deleted successfully'
        ]);

    }


    public function destroyParticipant(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:participants,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $Participant = Participant::find($request->id);

        if (!$Participant) {
            return response()->json([
                'status' => false,
                'message' => 'Participant not found'
            ]);
        }

        $Participant->delete();

        return response()->json([
            'status' => true,
            'message' => 'Participant deleted successfully'
        ]);
    }


    public function checkScreenshot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'school' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $count = School::where("school", $request->school)->whereNotNull("screenshot")->count();

        if ($count > 0) {
            Session::put('school', $request->school);

            return response()->json([
                'status' => true,
                'screenshot_exist' => true
            ]);
        }

        return response()->json([
            'status' => true,
            'screenshot_exist' => false
        ]);
    }

    public function storeScreenshot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'school' => 'required',
            'screenshot' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $fileUploader = new FileUploadHelper(public_path('uploads/screenshots'), 'screenshot');
        $file_response = $fileUploader->handleFile($request);

        if ($file_response['status']) {
            $file = $file_response['upload_data'][0]; //accessing the zero index because there is single file in our request

            School::create([
                'school' => $request->school,
                'screenshot' => $file['file_name'],
            ]);

            Session::put('school', $request->school);

            return response()->json([
                'status' => true,
                'message' => 'Screenshot Saved successfully'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Screenshot could not be saved'
        ]);
    }

    public function downloadPdf(Request $request)
    {
        // Fetch all schools ordered by school_name
        $schools = School::orderBy("school_name", "ASC")->get();

        if ($schools->count() < 1) {
            return response()->json([
                'status' => false,
                'message' => "No record found"
            ]);
        }

        // Determine template based on type
        $type = $request->get('type', 'with_visitors');
        $template = $type === 'without_visitors' ? 'schools.download-template-without-visitors' : 'schools.download-template';

        // Generate a unique filename
        $filename = date('ymdhis');

        // Load the PDF view with updated fields
        $pdf = Pdf::loadView($template, [
            'schools' => $schools,
            'jpg_logo_url' => asset('assets/media/logo.jpg')
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

}
