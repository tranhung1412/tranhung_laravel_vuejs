<?php

namespace App\Http\Controllers;


use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Carbon\Carbon;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $order = Order::where('status', 0)->whereDate('created_at', '>=', Carbon::now()->subDays(7))->groupBy('created_at')->get();
        foreach ($order as $key => $value) {
            $quantity = 0;
            $orderDetail = OrderDetail::where('created_at', $value->created_at)->get();

            foreach ($orderDetail as $key2 => $value2){
                $quantity += $value2->quantity;
            }
            $order[$key]['quantity'] = $quantity;
            $order[$key] = $value;

        }
        return response()->json($order);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function getAllOrderPaging($numberItem)
    {
        $order = Order::paginate($numberItem);
        foreach ($order as $key => $value) {
            $order[$key]['orderDetail'] = OrderDetail::where('idOrder', $value->id)->get();
            $order[$key] = $value;
        }
        return response()->json($order);
    }

    
    public function getChartShip()
    {
        $order = Order::where('status', 1)->whereDate('created_at', '>=', Carbon::now()->subDays(7))->groupBy('created_at')->get();
        foreach ($order as $key => $value) {
            $quantity = 0;
            $orderDetail = OrderDetail::where('created_at', $value->created_at)->get();

            foreach ($orderDetail as $key2 => $value2){
                $quantity += $value2->quantity;
            }
            $order[$key]['quantity'] = $quantity;
            $order[$key] = $value;
        }
        return response()->json($order);
    }
}
