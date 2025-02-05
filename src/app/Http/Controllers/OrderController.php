<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Ration;
use App\Models\Tariff;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\RationService;
use App\Http\Requests\Order\StoreRequest;
use App\Services\CarbonArrayToDatesArray;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('order.index', ['orders' => Order::all()]);
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
        $order = Order::create([
            'client_name' => $request->get('name'),
            'client_phone' => $request->get('phone'),
            'tariff_id' => $request->get('tariff'),
            'schedule_type' => $request->get('schedule_type'),
            'comment' => $request->get('comment'),
            'first_date' => $request->get('firstDate'),
            'last_date' => $request->get('lastDate'),
        ]);


        $rationService->setTariff($request->get('tariff'));
        $rationService->setFirstDateRange($request->get('firstDate'));
        $rationService->setLastDateRange($request->get('lastDate'));
        $rationService->setScheduleType($request->get('schedule_type'));
        $rationService->handle();

        
        $deliveryRations = $rationService->getDeliveryRations();
        $cookingRations = $rationService->getCookingRations();


        foreach($deliveryRations as $key => $ration)
        {
            Ration::create([
                'order_id' => $order->id,
                'delivery_date' => $ration,
                'cooking_date' => $cookingRations[$key],
            ]);
        }

        return Redirect()->route('orders'); 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::where('id', $id)->with('tariff')->get()->first();

        $rations = Ration::where('order_id', $id)->get();


        return view('order.show', ['order' => $order, 'rations' => $rations]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Order::where('id', $id)->delete();

        return Redirect()->route('orders');
    }
}
