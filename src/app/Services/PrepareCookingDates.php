<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Tariff;

class PrepareCookingDates
{
    private array $enterData = [];
    private CreateCarbonDeliveryPeriod $creator;
    private $carbonPeriod;
    private $cookingRations;

    /**
     * 
     */
    public function __construct()
    {
        $this->creator = new CreateCarbonDeliveryPeriod();
    }

    /**
     * 
     */
    public function getCookingRations(): array
    {
        return $this->cookingRations;
    }

    /**
     * 
     */
    public function setEnterData($tariffId, $scheduleType, $firstDateRange, $lastDateRange): void
    {
        $this->enterData = [
            'tariffId' => $tariffId,
            'scheduleType' => $scheduleType,
            'firstDateRange' => $firstDateRange,
            'lastDateRange' => $lastDateRange,
        ];
    }

    /**
     * 
     */
    private function tariffCookingIsAdvance(): bool
    {
        $queryTariff = Tariff::where('id', $this->enterData['tariffId'])->get()->first();
        return $queryTariff->cooking_day_before;
    }

    /**
     * 
     */
    public function prepare()
    {
        $this->carbonPeriod = $this->creator->create()->getPeriod();
        $cookingDays = [];
        
        foreach($this->cookingRations as $day)
        {
            if($this->tariffCookingIsAdvance() == true){
                array_push($cookingDays, Carbon::create($day)->subDay());
            } else {
                array_push($cookingDays, Carbon::create($day));
            }
        }

        $this->cookingRations = $cookingDays;
    }
}