<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DuskTestingSeeder extends Seeder
{
    public function run(): void
    {
        
        DB::table('fakultas')->insert([
            [
                'id' => 1, 
                'nama_fakultas' => 'Teknik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('prodis')->insert([
            [
                'id'           => 1,
                'nama_prodi'   => 'Informatika',
                'fakultas_id'  => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);

        DB::table('users')->insert([
            [
                'id'       => 1,
                'name'     => 'Admin Sistem',
                'email'    => 'admin@test.com',
                'password' => Hash::make('password'),
                'role'     => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'       => 2,
                'name'     => 'Mahasiswa Testing',
                'email'    => 'mahasiswa@test.com',
                'password' => Hash::make('password'),
                'role'     => 'mahasiswa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('mahasiswas')->insert([
            [
                'id'        => 1,
                'user_id'   => 2,
                'nim'       => '2023001',
                'nama'      => 'Mahasiswa Testing',
                'prodi_id'  => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('mata_kuliahs')->insert([
            [
                'id' => 1,
                'kode' => 'IF201',
                'nama_matakuliah' => 'UKPL',
                'sks' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'kode' => 'IF202',
                'nama_matakuliah' => 'Pemrograman Mobile',
                'sks' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('krs')->insert([
            [
                'mahasiswa_id' => 1,
                'matakuliah_id' => 1,
                'semester' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 1,
                'matakuliah_id' => 2,
                'semester' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
