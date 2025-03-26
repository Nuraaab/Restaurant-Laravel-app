<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OnlinePaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('online_payments')->insert([
            'name' => 'Chapa',
            'description' => 'Chapa is a payment gateway providing digital payment solutions in Ethiopia.',
            'information' => json_encode([
                'secret_key' => 'your-secret-key-here',
                'public_key' => 'your-public-key-here'
            ]),
            'status' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
