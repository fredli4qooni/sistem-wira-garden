<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Facility;

class FacilityController extends Controller
{
    public function index()
    {
        $facilities = Facility::all();
        return view('admin.facilities.index', compact('facilities'));
    }

    public function create()
    {
        return view('admin.facilities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_path' => 'nullable|image|max:2048',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('facilities', 'public');
            $validated['image_path'] = $path;
        }

        $validated['is_active'] = $request->has('is_active');

        Facility::create($validated);
        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function edit(Facility $facility)
    {
        return view('admin.facilities.edit', compact('facility'));
    }

    public function update(Request $request, Facility $facility)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_path' => 'nullable|image|max:2048',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image_path')) {
            if ($facility->image_path && !str_starts_with($facility->image_path, 'images/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $facility->image_path));
            }
            $path = $request->file('image_path')->store('facilities', 'public');
            $validated['image_path'] = $path;
        }

        $validated['is_active'] = $request->has('is_active');

        $facility->update($validated);
        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas berhasil diperbarui.');
    }

    public function destroy(Facility $facility)
    {
        if ($facility->image_path && !str_starts_with($facility->image_path, 'images/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $facility->image_path));
        }
        $facility->delete();
        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas berhasil dihapus.');
    }
}
