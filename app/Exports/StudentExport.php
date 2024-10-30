<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Student::select(
            'name',
            'private_number',
            'grade',
            'group',
            'sector',
            'parent_name',
            'parent_mail',
            'parent_number',
            'additional_information',
            'contract_start_date',
            'contract_end_date',
            'yearly_payment',
            'monthly_payment',
            'currency',
            'parent_account',
            'income_account',
            'payment_quantity',
            'custom_discount',
            'email_notifications',
            'mobile_notifications'
        )->get();
    }

    public function headings(): array
    {
        return [
            'name',
            'private_number',
            'grade',
            'group',
            'sector',
            'parent_name',
            'parent_mail',
            'parent_number',
            'additional_information',
            'contract_start_date',
            'contract_end_date',
            'yearly_payment',
            'monthly_payment',
            'currency',
            'parent_account',
            'income_account',
            'payment_quantity',
            'custom_discount',
            'email_notifications',
            'mobile_notifications'
        ];
    }
}
