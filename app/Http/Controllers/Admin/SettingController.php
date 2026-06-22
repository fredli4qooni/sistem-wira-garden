<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all();
        return view('admin.settings.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $settings = Setting::all();

        foreach ($settings as $setting) {
            $key = $setting->key;

            if ($setting->type === 'image' && $request->hasFile($key)) {
                // Hapus gambar lama jika ada dan bukan gambar bawaan (images/...)
                if ($setting->value && !str_starts_with($setting->value, 'images/')) {
                    $oldPath = str_replace('storage/', '', $setting->value);
                    Storage::disk('public')->delete($oldPath);
                }
                
                $path = $request->file($key)->store('settings', 'public');
                $setting->update(['value' => 'storage/' . $path]);
                
            } elseif ($request->has($key)) {
                $setting->update(['value' => $request->input($key)]);
            }
        }

        return back()->with('success', 'Pengaturan Tampilan berhasil diperbarui!');
    }
}
