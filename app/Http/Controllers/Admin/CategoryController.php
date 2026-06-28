<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon_type' => 'required|in:svg,image',
            'icon_svg' => 'nullable|string',
            'icon_image' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        $category = new Category();
        $category->name = $validated['name'];
        $category->icon_type = $validated['icon_type'];
        $category->is_active = $request->has('is_active');

        if ($validated['icon_type'] == 'svg' && !empty($validated['icon_svg'])) {
            $category->icon_value = $validated['icon_svg'];
        } elseif ($validated['icon_type'] == 'image' && $request->hasFile('icon_image')) {
            $category->icon_value = $request->file('icon_image')->store('categories', 'public');
        }

        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon_type' => 'required|in:svg,image',
            'icon_svg' => 'nullable|string',
            'icon_image' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        $category->name = $validated['name'];
        $category->icon_type = $validated['icon_type'];
        $category->is_active = $request->has('is_active');

        if ($validated['icon_type'] == 'svg') {
            if (!empty($validated['icon_svg'])) {
                $category->icon_value = $validated['icon_svg'];
            }
        } elseif ($validated['icon_type'] == 'image') {
            if ($request->hasFile('icon_image')) {
                // Delete old if it's an image path
                if ($category->getOriginal('icon_type') == 'image' && $category->icon_value) {
                    Storage::disk('public')->delete($category->icon_value);
                }
                $category->icon_value = $request->file('icon_image')->store('categories', 'public');
            }
        }

        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        if ($category->destinations()->count() > 0) {
            return redirect()->route('admin.categories.index')->with('error', 'Kategori tidak dapat dihapus karena sedang digunakan oleh destinasi.');
        }

        if ($category->icon_type == 'image' && $category->icon_value) {
            Storage::disk('public')->delete($category->icon_value);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
