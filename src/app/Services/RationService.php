<?php

namespace App\Services;

use App\Models\Tariff;
use Carbon\CarbonPeriod;

class RationService
{
    private int $tariffId;
    private string $firstDateRange;
    private string $lastDateRange;
    private array $carbonDeliveryPeriodArray;
    private string $schedule_type;
    private array $rations;

    public function setScheduleType($scheduleType): void
    {
        $this->schedule_type = $scheduleType;
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

    private function tariffCookingIsAdvance(): bool
    {
        $queryTariff = Tariff::where('id', $this->tariffId)->get()->first();
        return $queryTariff->cooking_day_before;
    }

    private function createCarbonDeliveryPeriod(): void
    {
        $this->carbonDeliveryPeriodArray = CarbonPeriod::create($this->firstDateRange, $this->lastDateRange)->toArray();
    }

    private function prepareRationsDays(): void
    {
        $rations = [];

        if($this->schedule_type == 'EVERY_DAY') {
            foreach($this->carbonDeliveryPeriodArray as $date){
                array_push($rations, $date->format('Y-m-d'));
            }
        }

        if($this->schedule_type == 'EVERY_OTHER_DAY') {
            foreach($this->carbonDeliveryPeriodArray as $key => $date){
                if (0 === ($key % 2)) {
                    array_push($rations, $date->format('Y-m-d'));
                    continue;
                }
            }
        }

        if($this->schedule_type == 'EVERY_OTHER_DAY_TWICE') {
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