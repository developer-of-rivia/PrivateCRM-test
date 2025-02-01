<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Tariff;
use Carbon\CarbonPeriod;

class RationService
{
    private int $tariffId;
    private string $firstDateRange;
    private string $lastDateRange;
    private array $carbonDeliveryPeriodArray;
    private array $carbonCookingPeriodArray;
    private string $scheduleType;
    private array $rations;

    /**
     * 
     */
    public function getRations(): array
    {
        $this->prepareRationsDays();
        return $this->rations;
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
    private function createCarbonCookingPeriod(): void
    {
        $firstDateBefore = Carbon::create($this->firstDateRange)->subDay()->format('Y-m-d');
        $lastDateBefore = Carbon::create($this->lastDateRange)->subDay()->format('Y-m-d');
        $carbonCookingPeriodArray = CarbonPeriod::create($firstDateBefore, $lastDateBefore)->toArray();

        if($this->tariffCookingIsAdvance() == true){
            $this->carbonCookingPeriodArray = $carbonCookingPeriodArray;
        } else {
            $this->carbonCookingPeriodArray = $this->carbonDeliveryPeriodArray;
        }
    }

    /**
     * 
     */
    private function prepareRationsDays(): void
    {
        $this->createCarbonDeliveryPeriod();
        $this->createCarbonCookingPeriod();

        $rations = [];

        if($this->scheduleType == 'EVERY_DAY') {
            foreach($this->carbonDeliveryPeriodArray as $date){
                array_push($rations, $date->format('Y-m-d'));
            }
        }

        if($this->scheduleType == 'EVERY_OTHER_DAY') {
            foreach($this->carbonDeliveryPeriodArray as $key => $date){
                if (0 === ($key % 2)) {
                    array_push($rations, $date->format('Y-m-d'));
                    continue;
                }
            }
        }

        if($this->scheduleType == 'EVERY_OTHER_DAY_TWICE') {
            $daysInPeriod = count($this->carbonDeliveryPeriodArray);

            foreach($this->carbonDeliveryPeriodArray as $key => $date){
                if (0 === ($key % 2)) {
                    array_push($rations, $date->format('Y-m-d'));
                    array_push($rations, $date->format('Y-m-d'));
                    continue;
                }
            }

            if(!($daysInPeriod % 2 === 0)){
                unset($rations[count($rations) - 1]);
            }
        }

        $this->rations = $rations;
    }
}