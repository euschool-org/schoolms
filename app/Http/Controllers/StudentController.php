<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function dashboard()
    {
        $students = Student::all();
        return view('dashboard', compact('students'));
    }

    public function form(Student $student = null)
    {
        return view('student.form',[
            'student' => $student
        ]);
    }

    public function store(StoreStudentRequest $request)
    {
        if (Student::create($request->all())){
            return redirect()->route('student.create')->with('success','Student created successfully');
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
        if ($student->delete()){
            return redirect()->route('dashboard')->with('success','Student deleted successfully');
        } else {
            return redirect()->route('dashboard')->with('error','Student delete failed');
        }
    }
}
