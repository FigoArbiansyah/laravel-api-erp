<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('companies')->insert([
            [
                'name' => 'PT. Teknologi Nusantara',
                'email' => 'info@teknologi-nusantara.com',
                'phone' => '02112345678',
                'address' => 'Jl. Sudirman No. 45, Jakarta',
                'logo' => 'logos/teknologi-nusantara.png',
                'website' => 'https://www.teknologi-nusantara.com',
                'tax_id' => '123456789',
                'industry' => 'Teknologi',
                'status' => 'active',
                'subscription_plan' => 'premium',
                'subscription_expiry' => '2025-12-31',
                'owner_id' => null, // Sesuaikan dengan data user di tabel users
                'notes' => 'Perusahaan teknologi terbesar di Indonesia.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'CV. Jaya Abadi',
                'email' => 'contact@jayaabadi.co.id',
                'phone' => '02298765432',
                'address' => 'Jl. Braga No. 10, Bandung',
                'logo' => 'logos/jaya-abadi.png',
                'website' => 'https://www.jayaabadi.co.id',
                'tax_id' => '987654321',
                'industry' => 'Manufaktur',
                'status' => 'active',
                'subscription_plan' => 'basic',
                'subscription_expiry' => '2024-06-30',
                'owner_id' => null, // Sesuaikan dengan data user di tabel users
                'notes' => 'Fokus pada manufaktur peralatan rumah tangga.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
