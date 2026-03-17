<?php

namespace App\Rules;


use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class TificoEmail implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $allowedDomains = ['@tifico.co.id', '@intra.tifico.co.id'];

        foreach ($allowedDomains as $domain) {
            if (str_ends_with($value, $domain)) {
                return;
            }
        }

        $fail('Email must use domain tifico.co.id or intra.tifico.co.id');
    }
}
