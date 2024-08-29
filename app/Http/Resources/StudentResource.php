<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $status = match ($this->pupil_status){
            '0' => 'Future',
            '1' => 'Active',
            '-1' => 'Past',
        };
        return [
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'private_number' => $this->private_number,
            'grade' => $this->grade,
            'group' => $this->group,
            'sector' => $this->sector,
            'parent_mail' => $this->parent_mail,
            'parent_number' => $this->parent_number,
            'pupil_status' => $status,
            'additional_information' => $this->additional_information,
            'contract_end_date' => $this->contract_end_date,
            'yearly_payment' => $this->yearly_payment,
            'currency' => $this->currency,
            'parent_account' => $this->parent_account,
            'income_account' => $this->income_account,
            'payment_quantity' => $this->payment_quantity,
            'custom_discount' => $this->custom_discount,
        ];
    }
}
