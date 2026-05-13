<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(): JsonResponse
    {
        $profiles = Profile::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return response()->json($profiles);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:profiles,slug',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:500',
            'max_span_mm' => 'nullable|integer',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:100',
            'is_best_seller' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $profile = Profile::create($validated);

        return response()->json($profile, 201);
    }

    public function show(Profile $profile): JsonResponse
    {
        return response()->json($profile);
    }

    public function update(Request $request, Profile $profile): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'slug' => 'sometimes|string|max:255|unique:profiles,slug,' . $profile->id,
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:500',
            'max_span_mm' => 'nullable|integer',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:100',
            'is_best_seller' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $profile->update($validated);

        return response()->json($profile);
    }

    public function destroy(Profile $profile): JsonResponse
    {
        $profile->delete();

        return response()->json(null, 204);
    }
}
