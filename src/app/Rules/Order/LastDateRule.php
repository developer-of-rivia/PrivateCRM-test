<?php

namespace App\Rules\Order;

use Closure;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\ValidationRule;

class LastDateRule implements ValidationRule
{
    private string $firstDate;

    public function setFirstDate($date)
    {
        $this->firstDate = $date;
        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $carbonPeriod = Carbon::parse($this->firstDate)->lessThanOrEqualTo($value);

        if ($carbonPeriod == false) {
            $fail('Конечная дата не может быть меньше начальной');
        }
    }
}
