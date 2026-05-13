<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::all();
        return view('admin.materials.index', compact('materials'));
    }

    public function create()
    {
        return view('admin.materials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:materials,slug',
            'hex_color' => 'required|max:7',
            'description' => 'nullable',
            'image' => 'nullable',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        Material::create($validated);
        session()->flash('success', 'Material created successfully.');
        return redirect()->route('admin.materials.index');
    }

    public function show(Material $material)
    {
        return view('admin.materials.show', compact('material'));
    }

    public function edit(Material $material)
    {
        return view('admin.materials.edit', compact('material'));
    }

    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:materials,slug,' . $material->id,
            'hex_color' => 'required|max:7',
            'description' => 'nullable',
            'image' => 'nullable',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $material->update($validated);
        session()->flash('success', 'Material updated successfully.');
        return redirect()->route('admin.materials.index');
    }

    public function destroy(Material $material)
    {
        $material->delete();
        session()->flash('success', 'Material deleted successfully.');
        return redirect()->route('admin.materials.index');
    }
}
