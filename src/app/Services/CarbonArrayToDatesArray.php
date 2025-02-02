<?php

namespace App\Services;

//

class CarbonArrayToDatesArray
{
    private array $carbonArray = [];
    private array $simpleArray = [];

    public function setCarbonArray($array): void
    {
        $this->carbonArray = $array;
    }

    public function handle(): void
    {
        foreach($this->carbonArray as $date){
            array_push($this->simpleArray, $date->format('Y-m-d'));
        }
    }

    public function getSimpleArray(): array
    {
        return $this->simpleArray;
    }
}