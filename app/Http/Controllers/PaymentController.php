<?php

namespace App\Http\Controllers;

use App\Exports\PaymentExport;
use App\Http\Requests\StorePaymentRequest;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

    public function destroy(Payment $payment)
    {
        if ($payment->delete()) {
            return redirect()->route('dashboard')->with('success','Student deleted successfully');
        } else {
            return redirect()->route('dashboard')->with('error','Student delete failed');
        }
    }

    public function export(Request $request)
    {
        $dates = explode(' to ', $request->input('transaction_date'));

        $filters = [
            'transaction_from' => $dates[0] ?? null,
            'transaction_to' => $dates[1] ?? null,
        ];

        return Excel::download(new PaymentExport($filters), 'payments.xlsx');
    }
}
