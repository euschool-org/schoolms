<?php

namespace App\Exports;

use App\Models\Student;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public $filters;
    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Student::select(
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
        );
        if (!empty($this->filters['name'])) {
            $query->where('name', 'like', '%' . $this->filters['name'] . '%');
        }

        if (!empty($this->filters['private_number'])) {
            $query->where('private_number', 'like', '%' . $this->filters['private_number'] . '%');
        }

        if (!empty($this->filters['grade'])) {
            $query->whereIn('grade', $this->filters['grade']);
        }

        if (!empty($this->filters['group'])) {
            $query->whereIn('group', $this->filters['group']);
        }

        if (!empty($this->filters['sector'])) {
            $query->whereIn('sector', $this->filters['sector']);
        }

        if (!empty($this->filters['parent_name'])) {
            $query->where('parent_name', 'like', '%' . $this->filters['parent_name'] . '%');
        }

        if (!empty($this->filters['parent_mail'])) {
            $query->where('parent_mail', 'like', '%' . $this->filters['parent_mail'] . '%');
        }

        if (!empty($this->filters['parent_number'])) {
            $query->where('parent_number', 'like', '%' . $this->filters['parent_number'] . '%');
        }

        if (!empty($this->filters['pupil_status'])) {
            $pupilStatus = $this->filters['pupil_status'];

            $query->where(function ($query) use ($pupilStatus) {
                $now = Carbon::now();

                if (in_array('active', $pupilStatus)) {
                    // Add condition for 'active', including cases where contract_end_date is null
                    $query->orWhere(function ($query) use ($now) {
                        $query->whereDate('contract_start_date', '<=', $now)
                            ->where(function ($query) use ($now) {
                                $query->whereDate('contract_end_date', '>=', $now)
                                    ->orWhereNull('contract_end_date');
                            });
                    });
                }

                if (in_array('past', $pupilStatus)) {
                    // Add condition for 'past'
                    $query->orWhere(function ($query) use ($now) {
                        $query->whereDate('contract_end_date', '<', $now);
                    });
                }

                if (in_array('future', $pupilStatus)) {
                    // Add condition for 'future'
                    $query->orWhere(function ($query) use ($now) {
                        $query->whereDate('contract_start_date', '>', $now);
                    });
                }
            });
        }

        if (!empty($this->filters['additional_information'])) {
            $query->where('additional_information', 'like', '%' . $this->filters['additional_information'] . '%');
        }

        if (!empty($this->filters['contract_end_date'])) {
            $query->where('contract_end_date', $this->filters['contract_end_date']);
        }

        if (!empty($this->filters['yearly_payment_from'])) {
            $query->where('yearly_payment', '>=', $this->filters['yearly_payment_from']);
        }

        if (!empty($this->filters['yearly_payment_to'])) {
            $query->where('yearly_payment', '<=', $this->filters['yearly_payment_to']);
        }

        if (!empty($this->filters['currency'])) {
            $query->whereIn('currency', $this->filters['currency']);
        }

        if (!empty($this->filters['parent_account'])) {
            $query->where('parent_account', $this->filters['parent_account']);
        }

        if (!empty($this->filters['income_account'])) {
            $query->where('income_account', $this->filters['income_account']);
        }

        if (!empty($this->filters['payment_quantity'])) {
            $query->where('payment_quantity', $this->filters['payment_quantity']);
        }

        if (!empty($this->filters['custom_discount'])) {
            $query->where('custom_discount', $this->filters['custom_discount']);
        }

        return $query->get();
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
