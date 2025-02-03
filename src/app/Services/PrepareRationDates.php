<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Tariff;
use Carbon\CarbonPeriod;

class PrepareRationDates
{
    private $enterData;
    private PrepareCookingDates $prepareCookingDates;
    private PrepareDeliveryDates $prepareDeliveryDates;
    private CarbonArrayToDatesArray $carbonArrayToDatesArray;
    private $cookingDates;
    private $deliveryDates;
    private $resultDates;

    /**
     * 
     */
    public function getResultsDates(): array
    {
        return $this->resultDates;
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
    public function __construct()
    {
        $this->prepareCookingDates = new PrepareCookingDates();
        $this->prepareDeliveryDates = new PrepareDeliveryDates();
        $this->carbonArrayToDatesArray = new CarbonArrayToDatesArray();

        $this->resultDates = [
            'deliveryDates',
            'cookingDates',
        ]
    }

    /**
     * 
     */
    private function prepareDeliveryDates()
    {
        $this->prepareDeliveryDates->setEnterData(
            $this->enterData['tariffId'],
            $this->enterData['scheduleType'],
            $this->enterData['firstDateRange'],
            $this->enterData['lastDateRange'],
        );
        $this->prepareDeliveryDates->prepare();
        $this->deliveryDates = $this->prepareDeliveryDates->getRations();
    }

    private function prepareCookingDates()
    {
        $this->prepareCookingDates->setEnterData(
            $this->enterData['tariffId'],
            $this->enterData['scheduleType'],
            $this->enterData['firstDateRange'],
            $this->enterData['lastDateRange'],
        );
        $this->prepareCookingDates->prepare();
        $this->cookingDates = $this->prepareDeliveryDates->getRations();
    }

    /**
     * 
     */
    public function handle()
    {
        $this->prepareDeliveryDates();
        $this->prepareCookingDates();

        $deliveryDates = $this->carbonArrayToDatesArray->setCarbonArray($this->deliveryDates)->handle()->getSimpleArray();
        $cookingDates = $this->carbonArrayToDatesArray->setCarbonArray($this->cookingDates)->handle()->getSimpleArray();

        $this->resultDates['deliveryDates'] = $deliveryDates;
        $this->resultDates['cookingDates'] = $cookingDates;
    }
}