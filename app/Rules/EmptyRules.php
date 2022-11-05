<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class EmptyRules implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (!$value) {
            $fail(':attribute is empty');
        }
    }
}
