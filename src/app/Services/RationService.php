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
    private array $carbonDeliveryPeriodArray;
    private array $deliveryRations;
    private array $cookingRations;


    /**
     * 
     */
    public function getDeliveryRations(): array
    {
        $this->prepareDeliveryDays();
        return $this->deliveryRations;
    }

    public function getCookingRations(): array
    {
        $this->prepareCookingDays();
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

    public function setLastDateRange($date): void
    {
        $this->lastDateRange = $date;
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
        $this->carbonDeliveryPeriodArray = CarbonPeriod::create($this->firstDateRange, $this->lastDateRange)->toArray();
    }

    /**
     * 
     */
    private function prepareDeliveryDays(): void
    {
        $this->createCarbonDeliveryPeriod();
        $deliveryPeriodArray = [];


        if($this->scheduleType == 'EVERY_DAY') {
            foreach($this->carbonDeliveryPeriodArray as $date){
                array_push($deliveryPeriodArray, $date);
            }
        }

        if($this->scheduleType == 'EVERY_OTHER_DAY') {
            foreach($this->carbonDeliveryPeriodArray as $key => $date){
                if (0 === ($key % 2)) {
                    array_push($deliveryPeriodArray, $date);
                    continue;
                }
            }
        }

        if($this->scheduleType == 'EVERY_OTHER_DAY_TWICE') {
            $daysInPeriod = count($this->carbonDeliveryPeriodArray);

            foreach($this->carbonDeliveryPeriodArray as $key => $date){
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
    public function prepareCookingDays()
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
     * Вынести в отдельный класс переформирование массивов из карбона в обычные
     */
}