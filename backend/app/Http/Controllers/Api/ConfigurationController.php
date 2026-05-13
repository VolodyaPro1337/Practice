<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Configuration::with(['profile', 'material', 'automationOptions']);

        if ($request->has('session_token')) {
            $query->where('session_token', $request->session_token);
        }

        $configurations = $query->latest()->get();

        return response()->json($configurations);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'profile_id' => 'required|exists:profiles,id',
            'width_mm' => 'required|integer|min:1000|max:8000',
            'height_mm' => 'required|integer|min:1500|max:3500',
            'material_id' => 'required|exists:materials,id',
            'session_token' => 'nullable|string|max:255',
            'automation_options' => 'nullable|array',
            'automation_options.*.id' => 'required_with:automation_options|exists:automation_options,id',
            'automation_options.*.is_enabled' => 'required_with:automation_options|boolean',
        ]);

        $configuration = Configuration::create($validated);

        if (isset($validated['automation_options'])) {
            foreach ($validated['automation_options'] as $option) {
                $configuration->automationOptions()->attach($option['id'], [
                    'is_enabled' => $option['is_enabled'],
                ]);
            }
        }

        $configuration->load(['profile', 'material', 'automationOptions']);

        return response()->json($configuration, 201);
    }

    public function show(Configuration $configuration): JsonResponse
    {
        $configuration->load(['profile', 'material', 'automationOptions']);

        return response()->json($configuration);
    }

    public function update(Request $request, Configuration $configuration): JsonResponse
    {
        $validated = $request->validate([
            'profile_id' => 'sometimes|exists:profiles,id',
            'width_mm' => 'sometimes|integer|min:1000|max:8000',
            'height_mm' => 'sometimes|integer|min:1500|max:3500',
            'material_id' => 'sometimes|exists:materials,id',
            'session_token' => 'nullable|string|max:255',
            'automation_options' => 'nullable|array',
            'automation_options.*.id' => 'required_with:automation_options|exists:automation_options,id',
            'automation_options.*.is_enabled' => 'required_with:automation_options|boolean',
        ]);

        $configuration->update($validated);

        if (isset($validated['automation_options'])) {
            $configuration->automationOptions()->detach();
            foreach ($validated['automation_options'] as $option) {
                $configuration->automationOptions()->attach($option['id'], [
                    'is_enabled' => $option['is_enabled'],
                ]);
            }
        }

        $configuration->load(['profile', 'material', 'automationOptions']);

        return response()->json($configuration);
    }

    public function destroy(Configuration $configuration): JsonResponse
    {
        $configuration->automationOptions()->detach();
        $configuration->delete();

        return response()->json(null, 204);
    }
}
