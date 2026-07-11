<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Venue;
use App\Models\Field;
use App\Models\FieldSchedule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@sportbook.com',
            'phone' => '08111111111',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
        ]);

        // Admin / Pemilik Lapangan
        $admin = User::create([
            'name' => 'Admin SportBook',
            'email' => 'admin@sportbook.com',
            'phone' => '08222222222',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Customer Demo
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'customer@sportbook.com',
            'phone' => '08333333333',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        // Venue 1
        $venue1 = Venue::create([
            'owner_id' => $admin->id,
            'name' => 'SportBook Arena Utama',
            'address' => 'Jl. Olahraga No. 1, Kelurahan Maju',
            'city' => 'Jakarta',
            'description' => 'Kompleks olahraga lengkap dengan lapangan futsal, badminton, dan basket berkualitas tinggi.',
        ]);

        // Field 1 - Futsal
        $field1 = Field::create([
            'venue_id' => $venue1->id,
            'name' => 'Lapangan Futsal A',
            'sport_type' => 'Futsal',
            'price_per_hour' => 150000,
            'description' => 'Lapangan futsal rumput sintetis premium, cocok untuk pertandingan maupun latihan.',
            'is_active' => true,
        ]);

        // Field 2 - Badminton
        $field2 = Field::create([
            'venue_id' => $venue1->id,
            'name' => 'Lapangan Badminton 1',
            'sport_type' => 'Badminton',
            'price_per_hour' => 75000,
            'description' => 'Lapangan badminton indoor ber-AC dengan lantai kayu berkualitas.',
            'is_active' => true,
        ]);

        // Field 3 - Basket
        $field3 = Field::create([
            'venue_id' => $venue1->id,
            'name' => 'Lapangan Basket',
            'sport_type' => 'Basket',
            'price_per_hour' => 200000,
            'description' => 'Lapangan basket full size dengan tribun penonton dan pencahayaan malam.',
            'is_active' => true,
        ]);

        // Venue 2
        $venue2 = Venue::create([
            'owner_id' => $admin->id,
            'name' => 'GOR Mini Soccer Center',
            'address' => 'Jl. Stadion Raya No. 45',
            'city' => 'Bandung',
            'description' => 'Pusat olahraga mini soccer dan tenis terbaik di kota Bandung.',
        ]);

        // Field 4 - Mini Soccer
        $field4 = Field::create([
            'venue_id' => $venue2->id,
            'name' => 'Mini Soccer Field 1',
            'sport_type' => 'Mini Soccer',
            'price_per_hour' => 250000,
            'description' => 'Lapangan mini soccer dengan rumput artificial FIFA standard.',
            'is_active' => true,
        ]);

        // Field 5 - Tenis
        $field5 = Field::create([
            'venue_id' => $venue2->id,
            'name' => 'Lapangan Tenis A',
            'sport_type' => 'Tenis',
            'price_per_hour' => 120000,
            'description' => 'Lapangan tenis hard court dengan penerangan malam.',
            'is_active' => true,
        ]);

        // Schedules for all fields (Mon-Sun, 08:00-22:00)
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        foreach ([$field1, $field2, $field3, $field4, $field5] as $field) {
            foreach ($days as $day) {
                FieldSchedule::create([
                    'field_id' => $field->id,
                    'day_of_week' => $day,
                    'open_time' => '08:00:00',
                    'close_time' => '22:00:00',
                ]);
            }
        }
    }
}
