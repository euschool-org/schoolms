<?php

namespace App\Rules;

use App\Http\Controllers\StudentController;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidColumn implements ValidationRule
{

    protected $validColumns;

    public function __construct()
    {
        // Define or fetch the valid columns here
        $this->validColumns = StudentController::VALID_COLUMNS;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!in_array($value, $this->validColumns)) {
            $fail('The '.$attribute.' is not a valid column.');
        }
    }
}
