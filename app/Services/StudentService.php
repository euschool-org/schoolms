<?php

namespace App\Services;

use App\Models\Student;

class StudentService
{
    public function getStudents($request)
    {
        $query = Student::query();
        if ($request->filled('firstname')) {
            $query->where('firstname', 'like', '%' . $request->input('firstname') . '%');
        }

        if ($request->filled('lastname')) {
            $query->where('lastname', 'like', '%' . $request->input('lastname') . '%');
        }

        if ($request->filled('private_number')) {
            $query->where('private_number', 'like', '%' . $request->input('private_number') . '%');
        }

        if ($request->filled('grade')) {
            $query->where('grade', $request->input('grade'));
        }

        if ($request->filled('group')) {
            $query->where('group', $request->input('group'));
        }

        if ($request->filled('sector')) {
            $query->where('sector', $request->input('sector'));
        }

        if ($request->filled('parent_mail')) {
            $query->where('parent_mail', 'like', '%' . $request->input('parent_mail') . '%');
        }

        if ($request->filled('parent_number')) {
            $query->where('parent_number', 'like', '%' . $request->input('parent_number') . '%');
        }

        if ($request->filled('pupil_status')) {
            $query->where('pupil_status', $request->input('pupil_status'));
        }

        if ($request->filled('additional_information')) {
            $query->where('additional_information', 'like', '%' . $request->input('additional_information') . '%');
        }

        if ($request->filled('contract_end_date')) {
            $query->where('contract_end_date', $request->input('contract_end_date'));
        }

        if ($request->filled('yearly_payment')) {
            $query->where('yearly_payment', $request->input('yearly_payment'));
        }

        if ($request->filled('currency')) {
            $query->where('currency', $request->input('currency'));
        }

        if ($request->filled('parent_account')) {
            $query->where('parent_account', $request->input('parent_account'));
        }

        if ($request->filled('income_account')) {
            $query->where('income_account', $request->input('income_account'));
        }

        if ($request->filled('payment_quantity')) {
            $query->where('payment_quantity', $request->input('payment_quantity'));
        }

        if ($request->filled('custom_discount')) {
            $query->where('custom_discount', $request->input('custom_discount'));
        }
        $perPage = $request->get('per_page', 10);
        return $query->paginate($perPage);
    }
}
