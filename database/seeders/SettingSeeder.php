<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'color_primary', 'value' => '#047857', 'type' => 'color', 'label' => 'Warna Utama (Hijau)'],
            ['key' => 'color_accent', 'value' => '#ea580c', 'type' => 'color', 'label' => 'Warna Aksen (Oranye)'],
            ['key' => 'hero_title', 'value' => 'Wisata Alam Keluarga', 'type' => 'text', 'label' => 'Judul Hero'],
            ['key' => 'hero_subtitle', 'value' => 'Ciptakan momen tak terlupakan di alam bebas.', 'type' => 'textarea', 'label' => 'Sub-Judul Hero'],
            ['key' => 'hero_image', 'value' => 'images/gambar-keluarga.png', 'type' => 'image', 'label' => 'Gambar Hero'],
            ['key' => 'contact_whatsapp', 'value' => '6281234567890', 'type' => 'text', 'label' => 'Nomor WhatsApp Admin'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
