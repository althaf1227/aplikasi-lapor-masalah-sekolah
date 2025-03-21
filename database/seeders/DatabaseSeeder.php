<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Laporan;
use App\Models\Siswa;
use App\Models\Guru;
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

        // User::create([
        //     'nama' => 'althaf(guru)',
        //     'code_guru' => 'G123',
        //     'password' => Hash::make('G123'),
        //     'role' => 'guru',
        // ]);
    
        // User::create([
        //     'nama' => 'althaf(siswa)',
        //     'nis' => '18825',
        //     'password' => Hash::make('18825'),
        //     'role' => 'siswa',
        // ]);
        Siswa::create([
            'nama' => 'Andi Saputra',
            'nis' => '167',
            'kelas' => '10 IPA',
            'gambar'      => '',
        ]);
        Laporan::create([
            'judul_laporan' => 'Andi Saputra',
            'isi_laporan' => 'bjb',
            'tanggal_laporan' => '2007-8-8',
            'status_laporan' => 'fv',
            'guru_id' => '1',
        ]);

        Guru::create([
            'nama' => 'andi',
        ]);
    }
}
