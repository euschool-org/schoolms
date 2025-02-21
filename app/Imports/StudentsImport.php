<?php

namespace App\Imports;

use App\Models\Student;
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
                $studentService->syncStudentFees($student);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    private function validateRow(array $row)
    {
        return Validator::make($row, [
            'name' => 'required|string|max:191',
            'private_number' => 'nullable|string|max:45',
            'grade' => 'nullable|integer|max:12',
            'group' => 'nullable|in:ა,ბ,გ,დ,ე,ვ,ზ,თ,ი,კ,A,B,C,D,E,F,G,H,I,J,ქართული,ინგლისური',
            'sector' => 'nullable|in:ქართული,IB,ASAS,ბაღი',
            'additional_information' => 'nullable|string',
            'contract_start_date' => 'nullable|date',
            'contract_end_date' => 'nullable|date',
            'yearly_payment' => 'nullable|numeric',
            'monthly_payment' => 'nullable|numeric',
            'currency_id' => 'nullable|string|in:1,2,3',
            'parent_account' => 'nullable|string|max:12',
            'income_account' => 'nullable|string|max:10',
            'payment_quantity' => 'nullable|integer|max:10',
            'new_student_discount' => 'nullable|boolean',
            'parent_name' => 'nullable|string|max:191',
            'parent_mail' => 'nullable|email|max:255',
            'parent_number' => 'nullable|numeric|max:45',
            'email_notifications' => 'nullable|boolean',
            'mobile_notifications' => 'nullable|boolean',
            'last_year_balance' => 'nullable|numeric',
            'balance_change_year' => 'nullable|numeric',
        ])->validate();
    }
}
