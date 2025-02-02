<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Tariff;
use Carbon\CarbonPeriod;

class RationService
{
    private int $tariffId;
    private string $scheduleType;
    private string $firstDateRange;
    private string $lastDateRange;
    private array $carbonPeriod;
    private array $deliveryRations;
    private array $cookingRations;

    /**
     * 
     */
    public function getDeliveryRations(): array
    {
        return $this->deliveryRations;
    }

    public function getCookingRations(): array
    {
        return $this->cookingRations;
    }

    public function setScheduleType($scheduleType): void
    {
        $this->scheduleType = $scheduleType;
    }

    public function setTariff(int $tariffId): void
    {
        $this->tariffId = $tariffId;
    }

    public function setFirstDateRange($date): void
    {
        $this->firstDateRange = $date;
    }

    public function setLastDateRange($date): RationService
    {
        $this->lastDateRange = $date;
        return $this;
    }

    /**
     * 
     */

    public function handle(): void
    {
        $this->prepareDeliveryDays();
        $this->prepareCookingDays();
    }

    /**
     * 
     */
    private function tariffCookingIsAdvance(): bool
    {
        $queryTariff = Tariff::where('id', $this->tariffId)->get()->first();
        return $queryTariff->cooking_day_before;
    }

    /**
     * 
     */
    private function createCarbonDeliveryPeriod(): void
    {
        $this->carbonPeriod = CarbonPeriod::create($this->firstDateRange, $this->lastDateRange)->toArray();
    }

    /**
     * 
     */
    private function prepareDeliveryDays(): void
    {
        $this->createCarbonDeliveryPeriod();
        $deliveryPeriodArray = [];


        if($this->scheduleType == 'EVERY_DAY') {
            foreach($this->carbonPeriod as $date){
                array_push($deliveryPeriodArray, $date);
            }
        }

        if($this->scheduleType == 'EVERY_OTHER_DAY') {
            foreach($this->carbonPeriod as $key => $date){
                if (0 === ($key % 2)) {
                    array_push($deliveryPeriodArray, $date);
                    continue;
                }
            }
        }

        if($this->scheduleType == 'EVERY_OTHER_DAY_TWICE') {
            $daysInPeriod = count($this->carbonPeriod);

            foreach($this->carbonPeriod as $key => $date){
                if (0 === ($key % 2)) {
                    array_push($deliveryPeriodArray, $date);
                    array_push($deliveryPeriodArray, $date);
                    continue;
                }
            }

            if(!($daysInPeriod % 2 === 0)){
                unset($deliveryPeriodArray[count($deliveryPeriodArray) - 1]);
            }
        }

        $this->deliveryRations = $deliveryPeriodArray;
    }

    /**
     * 
     */
    private function prepareCookingDays()
    {
        $cookingDays = [];
        
        foreach($this->deliveryRations as $day)
        {
            if($this->tariffCookingIsAdvance() == true){
                array_push($cookingDays, Carbon::create($day)->subDay());
            } else {
                array_push($cookingDays, Carbon::create($day));
            }
        }

        $this->cookingRations = $cookingDays;
    }

    /**
     * 
     */
}