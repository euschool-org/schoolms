<?php

namespace App\Imports;

use App\Models\Student;
use App\Services\PaymentService;
use App\Services\StudentService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        DB::beginTransaction();
        try {
            foreach ($collection as $row) {
                $validatedData = $this->validateRow($row->toArray());
                $student = Student::create($validatedData);
                $studentService = new StudentService();
                $studentService->importFees(
                    $student,
                    $row['payment_quantity'] ?? null,
                    $row['yearly_fee'] ?? null
                );
                $paymentService = new PaymentService();
                if (isset($row['payment'])) {
                    $paymentService->importPayment($student, $row['payment']);
                }
                if ($row['individual_discount']){
                    $paymentService->importPayment($student, $row['individual_discount'], 3);
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }
    }

    private function validateRow(array $row)
    {
        return Validator::make($row, [
            'name' => 'required|string|max:191',
            'private_number' => 'nullable|string|max:45|unique:students,private_number',
            'grade' => 'nullable|integer|max:12',
            'group' => 'nullable|in:ა,ბ,გ,დ,ე,ვ,ზ,თ,ი,კ,A,B,C,D,E,F,G,H,I,J,ქართული,ინგლისური',
            'sector' => 'nullable|in:ქართული,IB,ASAS,ბაღი',
            'additional_information' => 'nullable|string',
            'contract_start_date' => 'nullable|date',
            'contract_end_date' => 'nullable|date',
            'currency_id' => 'nullable|in:1,2,3',
            'parent_account' => 'nullable|string|max:25',
            'income_account' => 'nullable|string|max:12',
            'new_student_discount' => 'nullable|boolean',
            'first_parent_name' => 'nullable|string|max:191',
            'first_parent_mail' => 'nullable|email|max:255',
            'first_parent_number' => 'nullable|numeric|digits_between:1,9',
            'second_parent_name' => 'nullable|string|max:191',
            'second_parent_mail' => 'nullable|email|max:255',
            'second_parent_number' => 'nullable|numeric|digits_between:1,9',
            'email_notifications' => 'nullable|boolean',
            'mobile_notifications' => 'nullable|boolean',
            'last_year_balance' => 'nullable|numeric',
            'balance_change_year' => 'nullable|numeric',
            'yearly_fee' => 'nullable|numeric',
            'payment_quantity' => 'nullable|integer',
            'payment' => 'nullable|numeric',
            'individual_discount' => 'nullable|numeric',
        ])->validate();
    }
}
