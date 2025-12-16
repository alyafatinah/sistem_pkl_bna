<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jurusan;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jurusan::insert([
            ['nama_jurusan' => 'Multimedia'],
            ['nama_jurusan' => 'Akuntansi'],
            ['nama_jurusan' => 'Kimia Industri'],
            ['nama_jurusan' => 'Farmasi'],
        ]);
    }
}
