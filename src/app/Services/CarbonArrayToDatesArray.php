<?php

namespace App\Services;

class CarbonArrayToDatesArray
{
    private array $carbonArray = [];
    private array $simpleArray = [];

    public function setCarbonArray(array $array): CarbonArrayToDatesArray
    {
        $this->carbonArray = $array;
        return $this;
    }

    public function handle(): CarbonArrayToDatesArray
    {
        foreach($this->carbonArray as $date){
            array_push($this->simpleArray, $date->format('Y-m-d'));
        }
        return $this;
    }

    public function getSimpleArray(): array
    {
        return $this->simpleArray;
    }
}