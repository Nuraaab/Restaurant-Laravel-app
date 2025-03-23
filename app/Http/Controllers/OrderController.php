<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);
        $query = Order::query();
        if (!empty($search)) {
            $query->where('name', 'like', "%$search%");
        }
        $data['orders'] = $query->orderBy('id', 'DESC')->paginate($perPage);
        $data['search'] = $search;
        $data['perPage'] = $perPage;
        return view('menu-management.orders.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('menu-management.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->delete();
        Session::flash('success', 'Order deleted successfully!');
        return back();
    }

    public function updateStatus(Request $request)
    {
        $validatedData = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'order_status' => 'required|string'
        ]);

        try {
            $order = Order::findOrFail($validatedData['order_id']);
            $order->order_status = $validatedData['order_status'];
            $order->save();

            Session::flash('success', "Order status set to {$validatedData['order_status']} successfully!");
        } catch (\Exception $e) {
            Session::flash('error', 'Failed to update order status. Please try again.');
        }

        return back();
    }
}
