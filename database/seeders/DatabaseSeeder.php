<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin Wira Garden',
            'email' => 'admin@wiragarden.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        \App\Models\Destination::create([
            'name' => 'Wira Garden',
            'description' => 'Taman wisata alam yang sejuk dan asri di Bandar Lampung, cocok untuk liburan keluarga.',
            'address' => 'Jl. Wan Abdurrahman, Batu Putuk, Kec. Teluk Betung Utara, Kota Bandar Lampung',
            'open_hours' => 'Senin - Minggu: 08:00 - 17:00 WIB',
            'maps_url' => 'https://maps.app.goo.gl/placeholder',
        ]);

        \App\Models\TicketType::insert([
            ['name' => 'Tiket Masuk Reguler', 'price' => 15000, 'description' => 'Tiket masuk area Wira Garden per orang', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tiket + Akses Kolam Renang', 'price' => 25000, 'description' => 'Tiket masuk plus kolam renang anak dan dewasa', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sewa Tenda Camping (Kapasitas 4 Org)', 'price' => 150000, 'description' => 'Termasuk tenda dan akses area camping semalaman', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
