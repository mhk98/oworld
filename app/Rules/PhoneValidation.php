<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Regex pattern for Bangladeshi phone numbers
        $pattern = '/^01[3-9]\d{8}$/';

        // Check if the value matches the pattern
        if (!preg_match($pattern, $value)) {
            $fail("The phone must be a valid Bangladeshi phone number.");
        }
    }
}
