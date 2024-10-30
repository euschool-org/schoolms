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
        return [
            'name' => $this->name,
            'private_number' => $this->private_number,
            'grade' => $this->grade,
            'group' => $this->group,
            'sector' => $this->sector,
            'parent_mail' => $this->parent_mail,
            'parent_number' => $this->parent_number,
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
