<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'nama' => 'althaf(guru)',
            'code_guru' => 'G123',
            'password' => Hash::make('G123'),
            'role' => 'guru',
        ]);
    
        User::create([
            'nama' => 'althaf(siswa)',
            'nis' => '18825',
            'password' => Hash::make('18825'),
            'role' => 'siswa',
        ]);
    }
}
