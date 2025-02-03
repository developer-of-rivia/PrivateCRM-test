<?php

namespace App\Services;

use Carbon\CarbonPeriod;

class CreateCarbonDeliveryPeriod
{
    private $period;
    private $firstDate;
    private $lastDate;

    public function setDates(string $firstDate, string $lastDate): void
    {
        $this->firstDate = $firstDate;
        $this->lastDate = $lastDate;
    }

    public function create(): CreateCarbonDeliveryPeriod
    {
        $this->period = CarbonPeriod::create($this->firstDate, $this->lastDate)->toArray();
        return $this;
    }

    public function getPeriod(): array
    {
        return $this->period;
    }
}