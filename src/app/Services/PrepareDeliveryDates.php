<?php

namespace App\Services;

use App\Services\CreateCarbonPeriod;

class PrepareDeliveryDates
{
    private $enterData;
    private $creator;
    private $carbonPeriod;
    private $deliveryRations;

    /**
     * 
     */
    public function __construct()
    {
        $this->creator = new CreateCarbonPeriod();
    }

    /**
     * 
     */
    public function getDeliveryRations(): array
    {
        return $this->deliveryRations;
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
    public function prepare()
    {
        $this->creator->setDates($this->enterData['firstDateRange'], $this->enterData['lastDateRange']);
        $this->creator->create();
        $this->carbonPeriod = $this->creator->getPeriod();


        $deliveryPeriodArray = [];


        if($this->enterData['scheduleType'] == 'EVERY_DAY') {
            foreach($this->carbonPeriod as $date){
                array_push($deliveryPeriodArray, $date);
            }
        }

        if($this->enterData['scheduleType'] == 'EVERY_OTHER_DAY') {
            foreach($this->carbonPeriod as $key => $date){
                if (0 === ($key % 2)) {
                    array_push($deliveryPeriodArray, $date);
                    continue;
                }
            }
        }

        if($this->enterData['scheduleType'] == 'EVERY_OTHER_DAY_TWICE') {
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