<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PaymentExport implements FromArray, WithHeadings, ShouldAutoSize
{
    public $filters;
    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function array(): array
    {
        $query = Payment::select('id', 'student_id', 'payment_date', 'payment_amount') // Select specific columns from Payment
        ->with(['student:id,private_number,name,parent_account,currency']); // Select specific columns from the Student relation


        if (!empty($this->filters['transaction_from'])) {
            $query->where('payment_date', '>=', $this->filters['transaction_from']);
        }

        if (!empty($this->filters['transaction_to'])) {
            $query->where('payment_date', '<=', $this->filters['transaction_to']);
        }

        $payments = $query->get();
        $data = [];
        foreach ($payments as $payment) {
            $data[] =
                [
                    $payment->payment_date,
                    $payment->student->private_number,
                    $payment->student->name,
                    $payment->student->parent_account,
//                    $payment->payment_amount / $payment->currency_rate,
                    'nominal',
                    $payment->payment_amount,
                    $payment->student->currency,
                ];
        }
        return $data;
    }

    public function headings(): array
    {
        return [
            'ტრანზაქციის თარიღი',
            'მოსწავლის პირადი ნომერი',
            'მოსწავლის დასახელება',
            'მშობელი ანგარიში',
            'ნომინალური თანხა',
            'თანხა ლარში',
            'ვალუტა',
        ];
    }
}
