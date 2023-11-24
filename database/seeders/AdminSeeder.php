<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        DB::table('admin')->insert([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => 1,
        ]);
    }
    // public function run(): void
    // {
    //     // \App\Models\User::factory(10)->create();

    //     // \App\Models\User::factory()->create([
    //     //     'name' => 'Test User',
    //     //     'email' => 'test@example.com',
    //     // ]);
        
    // }
}
