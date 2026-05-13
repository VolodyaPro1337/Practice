<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AutomationOption;
use Illuminate\Http\Request;

class AutomationOptionController extends Controller
{
    public function index()
    {
        $automationOptions = AutomationOption::all();
        return view('admin.automation_options.index', compact('automationOptions'));
    }

    public function create()
    {
        return view('admin.automation_options.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:automation_options,slug',
            'description' => 'nullable',
            'subtitle' => 'nullable',
            'icon' => 'nullable',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        AutomationOption::create($validated);
        session()->flash('success', 'Automation option created successfully.');
        return redirect()->route('admin.automation-options.index');
    }

    public function show(AutomationOption $automationOption)
    {
        return view('admin.automation_options.show', compact('automationOption'));
    }

    public function edit(AutomationOption $automationOption)
    {
        return view('admin.automation_options.edit', compact('automationOption'));
    }

    public function update(Request $request, AutomationOption $automationOption)
    {
        $validated = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:automation_options,slug,' . $automationOption->id,
            'description' => 'nullable',
            'subtitle' => 'nullable',
            'icon' => 'nullable',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $automationOption->update($validated);
        session()->flash('success', 'Automation option updated successfully.');
        return redirect()->route('admin.automation-options.index');
    }

    public function destroy(AutomationOption $automationOption)
    {
        $automationOption->delete();
        session()->flash('success', 'Automation option deleted successfully.');
        return redirect()->route('admin.automation-options.index');
    }
}
