<?php

namespace App\Http\Controllers;

use App\Exports\StudentExport;
use App\Http\Requests\ImportRequest;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Imports\StudentsImport;
use App\Mail\SendPdfMail;
use App\Models\Student;
use App\Services\AttachmentService;
use App\Services\StudentService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public const VALID_COLUMNS = [
        'grade_label',
        'group',
        'sector',
        'contract_start_date',
        'contract_end_date',
        'parent_name',
        'parent_mail',
        'parent_number',
        'yearly_payment',
        'currency',
        'parent_account',
        'income_account',
        'payment_quantity',
        'custom_discount',
        'additional_information',
    ];
    public $attachmentService;

    public $studentService;

    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
        $this->studentService = new StudentService();
    }
    public function dashboard(Authenticatable $user, Request $request)
    {
        $data = $this->studentService->getStudents($request);
        return view('dashboard', [
            'students' => $data['students'],
            'total_students' => $data['total_students'],
            'selectedColumns' => json_decode($user->column_preferences,true) ?? self::VALID_COLUMNS,
            'allColumns' => self::VALID_COLUMNS,
        ]);
    }

    public function form(Student $student = null)
    {
        if ($student) {
            $student->load(['payments', 'attachments.user']);
            $update = true;
        } else {
            $student = new Student([
                'name' => '',
                'private_number' => '',
                'grade' => null,
                'group' => '',
                'sector' => '',
                'pupil_status' => null,
                'additional_information' => ''
            ]);
            $update = false;
        }
        return view('student.form',[
            'student' => $student,
            'update' => $update,
        ]);
    }

    public function store(StoreStudentRequest $request)
    {
        $student = Student::create($request->all());
        if ($student){
            return redirect()->route('student.edit',$student->id)->with('success','Student created successfully');
        } else {
            return redirect()->route('student.create')->with('error','Something went wrong');
        }
    }

    public function update(Student $student, UpdateStudentRequest $request)
    {
        if ($student->update($request->validated())){
            return redirect()->route('student.edit',$student->id)->with('success','Student updated successfully');
        } else {
            return redirect()->route('student.edit',$student->id)->with('error','Student update failed');
        }
    }

    public function destroy(Student $student)
    {
        foreach ($student->attachments as $attachment){
            $this->attachmentService->deleteAttachment($attachment->filename);
        }

        if ($student->delete()){
            return redirect()->route('dashboard')->with('success','Student deleted successfully');
        } else {
            return redirect()->route('dashboard')->with('error','Student delete failed');
        }
    }

    public function import(ImportRequest $request)
    {
        Excel::import(new StudentsImport, $request->file('file'));

        return back()->with('success', 'Excel file imported successfully.');
    }

    public function export()
    {
        return Excel::download(new StudentExport, 'students.xlsx');
    }

    public function testMail()
    {
        $data = [
            'name' => 'John Doe',
            'amount' => '100.00'
        ];

        Mail::to('datigabashvili@gmail.com')->send(new SendPdfMail($data));

        return response()->json(['message' => 'Invoice sent successfully.']);
    }

}
