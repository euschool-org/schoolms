<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'private_number',
        'grade',
        'sector',
        'parent_mail',
        'parent_number',
        'pupil_status',
        'additional_information',
    ];
}
