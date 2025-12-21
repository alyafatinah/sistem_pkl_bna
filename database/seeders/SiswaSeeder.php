<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Mitra;
use App\Models\GuruPembimbing;
use App\Models\Jurusan;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        /**
         * DATA SISWA DUMMY
         * (tanpa hard-code ID mitra & guru)
         */
        $dataSiswa = [
            // Multimedia
            [
                'nis'   => '2023010001',
                'nama'  => 'Ahmad Rizky',
                'kelas' => 'XII Multimedia 1',
                'jurusan' => 'Multimedia',
                'bidang_mitra' => 'Multimedia',
                'email' => 'ahmad2@gmail.com',
                'alamat'=> 'Jl. Melati No. 1',
                'telp'  => '08111111001',
            ],
            [
                'nis'   => '2023010002',
                'nama'  => 'Dina Puspita',
                'kelas' => 'XII Multimedia 1',
                'jurusan' => 'Multimedia',
                'bidang_mitra' => 'Multimedia',
                'email' => 'dina@gmail.com',
                'alamat'=> 'Jl. Mawar No. 2',
                'telp'  => '08111111002',
            ],

            // Akuntansi
            [
                'nis'   => '2023020001',
                'nama'  => 'Rafi Akbar',
                'kelas' => 'XII Akuntansi 1',
                'jurusan' => 'Akuntansi',
                'bidang_mitra' => 'Akuntansi',
                'email' => 'rafi@gmail.com',
                'alamat'=> 'Jl. Kenanga No. 3',
                'telp'  => '08111111003',
            ],
            [
                'nis'   => '2023020002',
                'nama'  => 'Nabila Putri',
                'kelas' => 'XII Akuntansi 1',
                'jurusan' => 'Akuntansi',
                'bidang_mitra' => 'Akuntansi',
                'email' => 'nabila@gmail.com',
                'alamat'=> 'Jl. Anggrek No. 4',
                'telp'  => '08111111004',
            ],

            // Kimia Industri
            [
                'nis'   => '2023030001',
                'nama'  => 'Fajar Nugroho',
                'kelas' => 'XII Kimia Industri',
                'jurusan' => 'Kimia Industri',
                'bidang_mitra' => 'Kimia',
                'email' => 'fajar@gmail.com',
                'alamat'=> 'Jl. Dahlia No. 5',
                'telp'  => '08111111005',
            ],

            // Farmasi
            [
                'nis'   => '2023040001',
                'nama'  => 'Nova Fakhirah',
                'kelas' => 'XII Farmasi',
                'jurusan' => 'Farmasi',
                'bidang_mitra' => 'Farmasi',
                'email' => 'nova@gmail.com',
                'alamat'=> 'Jl. Teratai No. 6',
                'telp'  => '08111111006',
            ],
        ];

        foreach ($dataSiswa as $data) {

            /**
             * 1️⃣ AMBIL JURUSAN
             */
            $jurusan = Jurusan::where('nama_jurusan', $data['jurusan'])->first();

            if (!$jurusan) {
                throw new \Exception("Jurusan {$data['jurusan']} tidak ditemukan");
            }

            /**
             * 2️⃣ AMBIL MITRA SESUAI BIDANG
             */
            $mitra = Mitra::where('bidang', 'LIKE', "%{$data['bidang_mitra']}%")->first();

            if (!$mitra) {
                throw new \Exception("Mitra bidang {$data['bidang_mitra']} tidak ditemukan");
            }

            /**
             * 3️⃣ AMBIL GURU PEMBIMBING SESUAI JURUSAN
             */
            $guru = GuruPembimbing::where('jurusan_id', $jurusan->id)->first();

            if (!$guru) {
                throw new \Exception("Guru pembimbing jurusan {$data['jurusan']} tidak ditemukan");
            }

            /**
             * 4️⃣ USER SISWA (AMAN DUPLICATE)
             */
            $user = User::firstOrCreate(
                ['username' => $data['nis']],
                [
                    'name'     => $data['nama'],
                    'email'    => $data['email'],
                    'password' => Hash::make('siswa123'),
                    'role_id'  => 4, // ROLE SISWA
                ]
            );

            /**
             * 5️⃣ DATA SISWA (AMAN DUPLICATE)
             */
            Siswa::firstOrCreate(
                ['nis' => $data['nis']],
                [
                    'user_id'           => $user->id,
                    'nama'              => $data['nama'],
                    'kelas'             => $data['kelas'],
                    'alamat'            => $data['alamat'],
                    'telp'              => $data['telp'],
                    'jurusan_id'        => $jurusan->id,
                    'mitra_id'          => $mitra->id,
                    'gurupembimbing_id' => $guru->id,
                ]
            );
        }
    }
}
