<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Site;
use App\Models\Block;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Site::factory()->create([
            'name' => 'Default Site',
            'phone' => '0123456789',
            'address' => '123 Default St, City, Country',
        ]);

        Block::factory()->create([
            'site_id' => 1,
            'name' => 'Default Block',
            'description' => 'This is the default block.',
            'water_price' => 10.00,
            'electric_price' => 15.00,
            'status' => true,
        ]);

        Block::factory()->create([
            'site_id' => 1,
            'name' => 'Secondary Block',
            'description' => 'This is the secondary block.',
            'water_price' => 12.00,
            'electric_price' => 18.00,
            'status' => true,
        ]);

        User::factory()->create([
            'site_id' => '1',
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);
    }
}
