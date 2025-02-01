<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Tariff;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Requests\Order\StoreRequest;
use App\Services\RationService;

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
    public function store(StoreRequest $request, RationService $rationService)
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



        $rationService->setTariff($request->get('tariff'));
        $rationService->setFirstDateRange($request->get('firstDate'));
        $rationService->setLastDateRange($request->get('lastDate'));
        $rationService->setScheduleType($request->get('schedule_type'));
        dd($rationService->getRations());

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
