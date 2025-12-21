<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\GuruPembimbing;
use Illuminate\Support\Facades\Hash;

class GuruPembimbingSeeder extends Seeder
{
    public function run(): void
    {
        $guru = [
            // Multimedia (jurusan_id = 1)
            [
                'nama_guru' => 'Budi Santoso',
                'nip'       => '197801012006041001',
                'bidang'    => 'Multimedia',
                'jurusan_id'=> 1,
                'telp'      => '08123456001',
                'email'     => 'budi.multimedia@gmail.com',
            ],
            [
                'nama_guru' => 'Rina Wulandari',
                'nip'       => '198102152007042002',
                'bidang'    => 'Desain Grafis',
                'jurusan_id'=> 1,
                'telp'      => '08123456002',
                'email'     => 'rina.multimedia@gmail.com',
            ],

            // Akuntansi (jurusan_id = 2)
            [
                'nama_guru' => 'Agus Setiawan',
                'nip'       => '197905102005031003',
                'bidang'    => 'Akuntansi',
                'jurusan_id'=> 2,
                'telp'      => '08123456003',
                'email'     => 'agus.akuntansi@gmail.com',
            ],
            [
                'nama_guru' => 'Dewi Lestari',
                'nip'       => '198211202008042004',
                'bidang'    => 'Keuangan',
                'jurusan_id'=> 2,
                'telp'      => '08123456004',
                'email'     => 'dewi.akuntansi@gmail.com',
            ],

            // Kimia Industri (jurusan_id = 3)
            [
                'nama_guru' => 'Hendra Saputra',
                'nip'       => '197612152004021005',
                'bidang'    => 'Kimia Industri',
                'jurusan_id'=> 3,
                'telp'      => '08123456005',
                'email'     => 'hendra.kimia@gmail.com',
            ],

            // Farmasi (jurusan_id = 4)
            [
                'nama_guru' => 'Siti Aminah',
                'nip'       => '198409182010012006',
                'bidang'    => 'Farmasi',
                'jurusan_id'=> 4,
                'telp'      => '08123456006',
                'email'     => 'siti.farmasi@gmail.com',
            ],
        ];

        foreach ($guru as $data) {

            // 1️⃣ Buat akun user guru pembimbing
            $user = User::create([
                'name'     => $data['nama_guru'],
                'username' => $data['nip'],
                'email'    => $data['email'],
                'password' => Hash::make('guru123'),
                'role_id'  => 3, // pastikan role 3 = Guru Pembimbing
            ]);

            // 2️⃣ Buat data guru pembimbing
            GuruPembimbing::create([
                'user_id'    => $user->id,
                'nip'        => $data['nip'],
                'nama_guru'  => $data['nama_guru'],
                'bidang'     => $data['bidang'],
                'jurusan_id' => $data['jurusan_id'],
                'telp'       => $data['telp'],
            ]);
        }
    }
}
