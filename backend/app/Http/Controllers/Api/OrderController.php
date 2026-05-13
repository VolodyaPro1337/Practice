<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Order::with(['configuration.profile', 'configuration.material', 'configuration.automationOptions']);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->get();

        return response()->json($orders);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:50',
            'configuration_id' => 'nullable|exists:configurations,id',
            'profile_id' => 'nullable|exists:profiles,id',
            'width_mm' => 'nullable|integer|min:1000|max:8000',
            'height_mm' => 'nullable|integer|min:1500|max:3500',
            'material_id' => 'nullable|exists:materials,id',
            'automation_options' => 'nullable|array',
            'automation_options.*.id' => 'required_with:automation_options|exists:automation_options,id',
            'automation_options.*.is_enabled' => 'required_with:automation_options|boolean',
        ]);

        if (!isset($validated['configuration_id'])) {
            $configuration = Configuration::create([
                'profile_id' => $validated['profile_id'],
                'width_mm' => $validated['width_mm'],
                'height_mm' => $validated['height_mm'],
                'material_id' => $validated['material_id'],
                'session_token' => Str::uuid()->toString(),
            ]);

            if (isset($validated['automation_options'])) {
                foreach ($validated['automation_options'] as $option) {
                    $configuration->automationOptions()->attach($option['id'], [
                        'is_enabled' => $option['is_enabled'],
                    ]);
                }
            }

            $validated['configuration_id'] = $configuration->id;
        }

        $order = Order::create([
            'configuration_id' => $validated['configuration_id'],
            'client_name' => $validated['client_name'],
            'client_phone' => $validated['client_phone'],
            'status' => 'new',
        ]);

        $order->load(['configuration.profile', 'configuration.material', 'configuration.automationOptions']);

        return response()->json($order, 201);
    }

    public function show(Order $order): JsonResponse
    {
        $order->load(['configuration.profile', 'configuration.material', 'configuration.automationOptions']);

        return response()->json($order);
    }

    public function update(Request $request, Order $order): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'sometimes|string|in:new,processing,contacted,confirmed,cancelled',
            'admin_note' => 'nullable|string',
            'client_name' => 'sometimes|string|max:255',
            'client_phone' => 'sometimes|string|max:50',
        ]);

        $order->update($validated);

        $order->load(['configuration.profile', 'configuration.material', 'configuration.automationOptions']);

        return response()->json($order);
    }

    public function destroy(Order $order): JsonResponse
    {
        $order->delete();

        return response()->json(null, 204);
    }
}
