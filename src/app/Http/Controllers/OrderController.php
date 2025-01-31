<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Tariff;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Requests\Order\StoreRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('order.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('order.create', ['tariffs' => Order::getTariffs()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        // Order::create([
        //     'client_name' => $request->get('name'),
        //     'client_phone' => $request->get('phone'),
        //     'tariff_id' => $request->get('tariff'),
        //     'schedule_type' => $request->get('schedule_type'),
        //     'comment' => $request->get('comment'),
        //     'first_date' => $request->get('firstDate'),
        //     'last_date' => $request->get('lastDate'),
        // ]);

    


        
        $cookingDayBefore = Tariff::where('id', $request->get('tariff'))->get()->first()->cooking_day_before;
        


        $firstDate = $request->get('firstDate');
        $firstDateBefore = Carbon::create($firstDate)->subDay()->format('Y-m-d');
        $lastDate = $request->get('lastDate');
        $lastDateBefore = Carbon::create($lastDate)->subDay()->format('Y-m-d');


        $deliveryPeriod = CarbonPeriod::create($firstDate, $lastDate)->toArray();

        if($cookingDayBefore == false) {
            $cookingPeriod = $deliveryPeriod;
        } else {
            $cookingPeriod = CarbonPeriod::create($firstDate, $lastDate)->toArray();
        }


        /** */
        /** */
        /** */



        $rations = [];

        /**
         * Каждый день
         */
        if($request->get('schedule_type') == 'EVERY_DAY') {
            $cookingDate;

            if($cookingDayBefore == 0){
                $cookingDate = $deliveryPeriod;
            } else {
                $cookingDate = CarbonPeriod::create($firstDate, $lastDate)->toArray();
            }
    
            foreach($deliveryPeriod as $date){
                array_push($rations, $date->format('Y-m-d'));
            }
        }


        /**
         * Через день
         */
        if($request->get('schedule_type') == 'EVERY_OTHER_DAY') {
            
            foreach($deliveryPeriod as $key => $date){
                if (0 === ($key % 2)) {
                    array_push($rations, $date->format('Y-m-d'));
                    continue;
                }
            }
        }


        /**
         * Через день два раза
         */
        if($request->get('schedule_type') == 'EVERY_OTHER_DAY_TWICE') {
            $daysInPeriod = count($deliveryPeriod);

            foreach($deliveryPeriod as $key => $date){
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


        // dd($rations);




    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
