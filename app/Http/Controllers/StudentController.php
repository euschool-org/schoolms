<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use App\Services\AttachmentService;
use Illuminate\Contracts\Auth\Authenticatable;

class StudentController extends Controller
{
    public const VALID_COLUMNS = [
        'firstname',
        'lastname',
        'private_number',
        'grade',
        'group',
        'sector',
        'parent_mail',
        'parent_number',
        'pupil_status_label',
        'additional_information',
        'contract_end_date',
        'yearly_payment',
        'currency',
        'parent_account',
        'income_account',
        'payment_quantity',
        'custom_discount',
    ];
    public $attachmentService;

    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }
    public function dashboard(Authenticatable $user)
    {
        $students = Student::all();
        return view('dashboard', [
            'students' => $students,
            'selectedColumns' => json_decode($user->column_preferences,true) ?? self::VALID_COLUMNS,
            'allColumns' => self::VALID_COLUMNS,
        ]);
    }

    public function form(Student $student = null)
    {
        if ($student) {
            $student->load(['payments', 'attachments.user']);
        }
        return view('student.form',[
            'student' => $student,
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
        if ($student->update($request->all())){
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
}
