<?php

namespace App\Services;

use Carbon\CarbonPeriod;

class CreateCarbonPeriod
{
    private $period;
    private $firstDate;
    private $lastDate;

    public function setDates($firstDate, $lastDate): CreateCarbonPeriod
    {
        $this->firstDate = $firstDate;
        $this->lastDate = $lastDate;
        return $this;
    }

    public function create(): CreateCarbonPeriod
    {
        $this->period = CarbonPeriod::create($this->firstDate, $this->lastDate);
        return $this;
    }

    public function getPeriod()
    {
        return $this->period;
    }
}