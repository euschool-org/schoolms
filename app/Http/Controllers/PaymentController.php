<?php

namespace App\Http\Controllers;

use App\Exports\PaymentExport;
use App\Http\Requests\StorePaymentRequest;
use App\Models\Payment;
use App\Models\Student;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PaymentController extends Controller
{
    public $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }
    public function store(Student $student, StorePaymentRequest $request)
    {
        if ($this->paymentService->createPayment($student, $request->validated())) {
            return redirect()->route('student.edit', $student->id)->with('success', 'Payment created successfully');
        } else {
            return redirect()->route('student.edit', $student->id)->with('error', 'Something went wrong');
        }
    }

    public function destroy(Payment $payment)
    {
        if (!$payment->payment_id && $payment->delete()) {
            return redirect()->back()->with('success','Pyment deleted successfully');
        } else {
            return redirect()->back()->with('error','Payment delete failed');
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
