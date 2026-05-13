<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function index()
    {
        $configurations = Configuration::with(['profile', 'material', 'automationOptions'])->get();
        return view('admin.configurations.index', compact('configurations'));
    }

    public function create()
    {
        return view('admin.configurations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'profile_id' => 'required|exists:profiles,id',
            'width_mm' => 'required|integer|min:1000|max:8000',
            'height_mm' => 'required|integer|min:1500|max:3500',
            'material_id' => 'required|exists:materials,id',
            'session_token' => 'nullable',
            'automation_options' => 'nullable|array',
            'automation_options.*.id' => 'exists:automation_options,id',
            'automation_options.*.is_enabled' => 'boolean',
        ]);

        $automationOptions = $validated['automation_options'] ?? [];
        unset($validated['automation_options']);

        $configuration = Configuration::create($validated);

        $configuration->automationOptions()->sync(
            collect($automationOptions)->mapWithKeys(fn($o) => [$o['id'] => ['is_enabled' => $o['is_enabled']]])
        );

        session()->flash('success', 'Configuration created successfully.');
        return redirect()->route('admin.configurations.index');
    }

    public function show(Configuration $configuration)
    {
        $configuration->load(['profile', 'material', 'automationOptions']);
        return view('admin.configurations.show', compact('configuration'));
    }

    public function edit(Configuration $configuration)
    {
        $configuration->load('automationOptions');
        return view('admin.configurations.edit', compact('configuration'));
    }

    public function update(Request $request, Configuration $configuration)
    {
        $validated = $request->validate([
            'profile_id' => 'required|exists:profiles,id',
            'width_mm' => 'required|integer|min:1000|max:8000',
            'height_mm' => 'required|integer|min:1500|max:3500',
            'material_id' => 'required|exists:materials,id',
            'session_token' => 'nullable',
            'automation_options' => 'nullable|array',
            'automation_options.*.id' => 'exists:automation_options,id',
            'automation_options.*.is_enabled' => 'boolean',
        ]);

        $automationOptions = $validated['automation_options'] ?? [];
        unset($validated['automation_options']);

        $configuration->update($validated);

        $configuration->automationOptions()->sync(
            collect($automationOptions)->mapWithKeys(fn($o) => [$o['id'] => ['is_enabled' => $o['is_enabled']]])
        );

        session()->flash('success', 'Configuration updated successfully.');
        return redirect()->route('admin.configurations.index');
    }

    public function destroy(Configuration $configuration)
    {
        $configuration->delete();
        session()->flash('success', 'Configuration deleted successfully.');
        return redirect()->route('admin.configurations.index');
    }
}
