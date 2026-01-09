<?php

namespace App\Rules;

use App\Services\Util\UrlService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class PublicUrl implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string, ?string=): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!UrlService::validate($value)) {
            $fail('The :attribute is not a valid public URL.');
        }
    }
}
