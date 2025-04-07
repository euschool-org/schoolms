<?php

namespace App\Exports;

use App\Models\Student;
use App\Services\StudentService;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public $students;
    public function __construct($students)
    {
        $this->students = $students;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->students->map(function ($student) {
            return [
                'name' => $student->name,
                'private_number' => $student->private_number,
                'grade' => $student->grade,
                'group' => $student->group,
                'sector' => $student->sector,
                'contract_start_date' => $student->contract_start_date,
                'contract_end_date' => $student->contract_end_date,
                'currency' => $student->currency->code, // Assuming currency has a `name` column
                'parent_account' => $student->parent_account,
                'income_account' => $student->income_account,
                'last_year_balance' => $student->last_year_balance,
                'yearly_fee' => $student->yearly_fee,
                'yearly_individual_discounts_sum' => $student->yearly_individual_discounts_sum ,
                'yearly_5p_discounts_sum' => $student->yearly_5p_discounts_sum,
                'yearly_10p_discounts_sum' => $student->yearly_10p_discounts_sum,
                'yearly_payments_sum' => $student->yearly_payments_sum,
                'final_balance' => $student->final_balance,
                'debt' => $student->debt,
                'first_half' => $student->first_half,
                'second_half' => $student->second_half,
                'payment_quantity' => $student->payment_quantity,
                'additional_information' => $student->additional_information,
                'first_parent_name' => $student->first_parent_name,
                'first_parent_mail' => $student->first_parent_mail,
                'first_parent_number' => $student->first_parent_number,
                'second_parent_name' => $student->second_parent_name,
                'second_parent_mail' => $student->second_parent_mail,
                'second_parent_number' => $student->second_parent_number,
            ];
        });
    }

    public function headings(): array
    {
        return [
                'name',
                'private_number',
                'grade',
                'group',
                'sector',
                'contract_start_date',
                'contract_end_date',
                'currency',
                'parent_account',
                'income_account',
                'last_year_balance',
                'yearly_fee',
                'yearly_individual_discounts_sum',
                'yearly_5p_discounts_sum',
                'yearly_10p_discounts_sum',
                'yearly_payments_sum',
                'final_balance',
                'debt',
                'first_half',
                'second_half',
                'payment_quantity',
                'additional_information',
                'first_parent_name',
                'first_parent_mail',
                'first_parent_number',
                'second_parent_name',
                'second_parent_mail',
                'second_parent_number',
        ];
    }
}
