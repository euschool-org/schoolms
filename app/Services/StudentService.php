<?php

namespace App\Services;

use App\Models\Student;

class StudentService
{
    public function getStudents($request)
    {
        $data= [];
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
            $query->whereIn('grade', $request->input('grade'));
        }

        if ($request->filled('group')) {
            $query->whereIn('group', $request->input('group'));
        }

        if ($request->filled('sector')) {
            $query->whereIn('sector', $request->input('sector'));
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

        if ($request->filled('yearly_payment_from')) {
            $query->where('yearly_payment', '>=', $request->input('yearly_payment_from'));
        }

        if ($request->filled('yearly_payment_to')) {
            $query->where('yearly_payment', '<=', $request->input('yearly_payment_to'));
        }

        if ($request->filled('currency')) {
            $query->whereIn('currency', $request->input('currency'));
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
        $totalQuery = clone $query;
        $totalStudents = $totalQuery->count();

        // Paginate the query
        $perPage = $request->get('per_page', 10);
        $students = $query->paginate($perPage);

        // Return the students and total count
        $data['students'] = $students;
        $data['total_students'] = $totalStudents;

        return $data;
    }
}
