<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('configuration')->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        return view('admin.orders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'configuration_id' => 'required|exists:configurations,id',
            'client_name' => 'required',
            'client_phone' => 'required',
            'status' => 'sometimes|in:new,processing,contacted,confirmed,cancelled',
            'admin_note' => 'nullable|string',
        ]);

        Order::create($validated);
        session()->flash('success', 'Order created successfully.');
        return redirect()->route('admin.orders.index');
    }

    public function show(Order $order)
    {
        $order->load('configuration.profile', 'configuration.material', 'configuration.automationOptions');
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'sometimes|in:new,processing,contacted,confirmed,cancelled',
            'admin_note' => 'nullable|string',
        ]);

        $order->update($validated);
        session()->flash('success', 'Order updated successfully.');
        return redirect()->route('admin.orders.index');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        session()->flash('success', 'Order deleted successfully.');
        return redirect()->route('admin.orders.index');
    }
}
