<?php

namespace App\Rules;

use App\Models\Currency;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CurrencyValidationRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $currencies = explode(',', $value);

        foreach ($currencies as $currency) {
            if (!Currency::where('name', $currency)->exists()) {
                $fail('Invalid currency provided.');
            }
        }
    }
}
