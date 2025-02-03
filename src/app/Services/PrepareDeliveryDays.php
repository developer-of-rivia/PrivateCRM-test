<?php

namespace App\Services;

use App\Services\CreateCarbonDeliveryPeriod;

class PrepareDeliveryDays
{
    private array $enterData = [];
    private CreateCarbonDeliveryPeriod $creator;
    private $carbonPeriod;

    public function __construct()
    {
        $this->creator = new CreateCarbonDeliveryPeriod();
        $this->creator->setDates();
    }

    public function setEnterData($tariffId, $scheduleType, $firstDateRange, $lastDateRange)
    {
        $this->enterData = [
            'tariffId' => $tariffId,
            'scheduleType' => $scheduleType,
            'firstDateRange' => $firstDateRange,
            'lastDateRange' => $lastDateRange,
        ];
    }

    public function handle()
    {
        $this->createCarbonDeliveryPeriod();
        $deliveryPeriodArray = [];


        if($this->enterData['shceduleType'] == 'EVERY_DAY') {
            foreach($this->carbonPeriod as $date){
                array_push($deliveryPeriodArray, $date);
            }
        }

        if($this->enterData['shceduleType'] == 'EVERY_OTHER_DAY') {
            foreach($this->carbonPeriod as $key => $date){
                if (0 === ($key % 2)) {
                    array_push($deliveryPeriodArray, $date);
                    continue;
                }
            }
        }

        if($this->enterData['shceduleType'] == 'EVERY_OTHER_DAY_TWICE') {
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
}