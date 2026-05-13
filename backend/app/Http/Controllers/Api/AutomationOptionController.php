<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AutomationOption;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AutomationOptionController extends Controller
{
    public function index(): JsonResponse
    {
        $options = AutomationOption::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return response()->json($options);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:automation_options,slug',
            'description' => 'nullable|string',
            'subtitle' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $option = AutomationOption::create($validated);

        return response()->json($option, 201);
    }

    public function show(AutomationOption $automationOption): JsonResponse
    {
        return response()->json($automationOption);
    }

    public function update(Request $request, AutomationOption $automationOption): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'slug' => 'sometimes|string|max:255|unique:automation_options,slug,' . $automationOption->id,
            'description' => 'nullable|string',
            'subtitle' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $automationOption->update($validated);

        return response()->json($automationOption);
    }

    public function destroy(AutomationOption $automationOption): JsonResponse
    {
        $automationOption->delete();

        return response()->json(null, 204);
    }
}
