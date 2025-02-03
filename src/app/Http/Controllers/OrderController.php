<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Tariff;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\PrepareRationDates;
use App\Http\Requests\Order\StoreRequest;
use App\Services\CarbonArrayToDatesArray;

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
    public function store(StoreRequest $request, PrepareRationDates $prepareRationDates)
    {
        $tarifId = $request->get('tariff');
        $shceduleType = $request->get('schedule_type');
        $firstDateRange = $request->get('firstDate');
        $lastDateRange = $request->get('lastDate');


        // Order::create([
        //     'client_name' => $request->get('name'),
        //     'client_phone' => $request->get('phone'),
        //     'tariff_id' => $request->get('tariff'),
        //     'schedule_type' => $request->get('schedule_type'),
        //     'comment' => $request->get('comment'),
        //     'first_date' => $request->get('firstDate'),
        //     'last_date' => $request->get('lastDate'),
        // ]);


        $prepareRationDates->setEnterData($tarifId, $shceduleType, $firstDateRange, $lastDateRange);
        $prepareRationDates->handle();
        

        // dd($prepareRationDates->getResultsDates());


        

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
