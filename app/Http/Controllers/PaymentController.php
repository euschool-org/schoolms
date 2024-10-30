<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Student $student, StorePaymentRequest $request)
    {
        $data = $request->validated();
        $data['student_id'] = $student->id;

        if (Payment::create($data)) {
            return redirect()->route('student.edit', $student->id)->with('success', 'Payment created successfully');
        } else {
            return redirect()->route('student.edit', $student->id)->with('error', 'Something went wrong');
        }
    }
    //test
    public function destroy(Payment $payment)
    {
        if ($payment->delete()) {
            return redirect()->route('dashboard')->with('success','Student deleted successfully');
        } else {
            return redirect()->route('dashboard')->with('error','Student delete failed');
        }
    }
}
