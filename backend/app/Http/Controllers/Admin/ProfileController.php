<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = Profile::all();
        return view('admin.profiles.index', compact('profiles'));
    }

    public function create()
    {
        return view('admin.profiles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:profiles,slug',
            'description' => 'nullable',
            'image' => 'nullable',
            'max_span_mm' => 'nullable|integer',
            'tags' => 'nullable|array',
            'tags.*' => 'string',
            'is_best_seller' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        Profile::create($validated);
        session()->flash('success', 'Profile created successfully.');
        return redirect()->route('admin.profiles.index');
    }

    public function show(Profile $profile)
    {
        return view('admin.profiles.show', compact('profile'));
    }

    public function edit(Profile $profile)
    {
        return view('admin.profiles.edit', compact('profile'));
    }

    public function update(Request $request, Profile $profile)
    {
        $validated = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:profiles,slug,' . $profile->id,
            'description' => 'nullable',
            'image' => 'nullable',
            'max_span_mm' => 'nullable|integer',
            'tags' => 'nullable|array',
            'tags.*' => 'string',
            'is_best_seller' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $profile->update($validated);
        session()->flash('success', 'Profile updated successfully.');
        return redirect()->route('admin.profiles.index');
    }

    public function destroy(Profile $profile)
    {
        $profile->delete();
        session()->flash('success', 'Profile deleted successfully.');
        return redirect()->route('admin.profiles.index');
    }
}
