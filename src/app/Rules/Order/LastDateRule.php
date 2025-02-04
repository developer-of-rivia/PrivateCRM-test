<?php

namespace App\Rules\Order;

use Closure;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\Validation\ValidationRule;

class LastDateRule implements ValidationRule
{
    private $firstDate;
    private $scheduleType;

    public function setFirstDate($date)
    {
        $this->firstDate = $date;
        return $this;
    }

    public function setScheduleType($type)
    {
        $this->scheduleType = $type;
        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $isLastDateAfterFirstDate = Carbon::parse($this->firstDate)->lessThanOrEqualTo($value);
        $isPeriodSuitForScheduleType = count(CarbonPeriod::create($this->firstDate, $value)->toArray());


        if(($this->scheduleType == 'EVERY_OTHER_DAY' || $this->scheduleType == 'EVERY_OTHER_DAY_TWICE') && $isPeriodSuitForScheduleType < 3)
        {
            $fail('Слишком маленький период для данного типа доставки');
        }

        if ($isLastDateAfterFirstDate == false)
        {
            $fail('Конечная дата не может быть меньше начальной');
        }
    }
}
