<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Destination;


class DestinationController extends Controller
{
    public function index()
    {
        $destinations = Destination::all();
        return view('admin.destinations.index', compact('destinations'));
    }

    public function create()
    {
        $facilities = \App\Models\Facility::where('is_active', true)->get();
        $categories = \App\Models\Category::where('is_active', true)->get();
        return view('admin.destinations.create', compact('facilities', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price_adult' => 'required|numeric|min:0',
            'price_child' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'facilities' => 'nullable|array',
            'facilities.*' => 'exists:facilities,id',
            'address' => 'required|string|max:255',
            'open_hours' => 'required|string|max:100',
            'maps_url' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if (empty($validated['facilities'])) {
            $validated['facilities'] = [];
        }

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('destinations', 'public');
        }

        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $file) {
                $galleryPaths[] = $file->store('destinations/galleries', 'public');
            }
            $validated['gallery_images'] = $galleryPaths;
        }

        Destination::create($validated);
        return redirect()->route('admin.destinations.index')->with('success', 'Destinasi berhasil ditambahkan.');
    }

    public function edit(Destination $destination)
    {
        $facilities = \App\Models\Facility::where('is_active', true)->get();
        $categories = \App\Models\Category::where('is_active', true)->get();
        $selectedFacilities = $destination->facilities ?? [];
        return view('admin.destinations.edit', compact('destination', 'facilities', 'categories', 'selectedFacilities'));
    }

    public function update(Request $request, Destination $destination)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price_adult' => 'required|numeric|min:0',
            'price_child' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'facilities' => 'nullable|array',
            'facilities.*' => 'exists:facilities,id',
            'address' => 'required|string|max:255',
            'open_hours' => 'required|string|max:100',
            'maps_url' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if (empty($validated['facilities'])) {
            $validated['facilities'] = [];
        }

        if ($request->hasFile('image')) {
            if ($destination->image_path) {
                Storage::disk('public')->delete($destination->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('destinations', 'public');
        }

        if ($request->has('clear_gallery') && $request->clear_gallery == '1') {
            if (is_array($destination->gallery_images)) {
                foreach ($destination->gallery_images as $path) {
                    Storage::disk('public')->delete($path);
                }
            }
            $validated['gallery_images'] = [];
            $destination->gallery_images = [];
        }

        if ($request->hasFile('gallery')) {
            $galleryPaths = $destination->gallery_images ?? [];
            foreach ($request->file('gallery') as $file) {
                $galleryPaths[] = $file->store('destinations/galleries', 'public');
            }
            $validated['gallery_images'] = $galleryPaths;
        }

        $destination->update($validated);
        return redirect()->route('admin.destinations.index')->with('success', 'Destinasi berhasil diperbarui.');
    }

    public function destroy(Destination $destination)
    {
        if ($destination->image_path) {
            Storage::disk('public')->delete($destination->image_path);
        }
        
        if (is_array($destination->gallery_images)) {
            foreach ($destination->gallery_images as $path) {
                Storage::disk('public')->delete($path);
            }
        }
        
        $destination->delete();
        return redirect()->route('admin.destinations.index')->with('success', 'Destinasi berhasil dihapus.');
    }
}
