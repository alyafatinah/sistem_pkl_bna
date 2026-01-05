<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Kaprod;
use App\Models\Jurusan;

class KaprodSeeder extends Seeder
{
    public function run(): void
    {
        /**
         * DATA KAPRODI
         * (1 kaprodi per jurusan)
         */
        $dataKaprod = [
            [
                'nip'          => '197701012005011001',
                'nama_kaprod'  => 'Drs. Haryono',
                'jurusan'      => 'Multimedia',
                'alamat'       => 'Jl. Pendidikan No. 1',
                'telp'         => '08122222001',
                'email'        => 'kaprod.multimedia@gmail.com',
            ],
            [
                'nip'          => '197802022006021002',
                'nama_kaprod'  => 'Sri Wahyuni, S.E.',
                'jurusan'      => 'Akuntansi',
                'alamat'       => 'Jl. Pendidikan No. 2',
                'telp'         => '08122222002',
                'email'        => 'kaprod.akuntansi@gmail.com',
            ],
            [
                'nip'          => '197903032007031003',
                'nama_kaprod'  => 'Dr. Ahmad Fauzi',
                'jurusan'      => 'Kimia Industri',
                'alamat'       => 'Jl. Pendidikan No. 3',
                'telp'         => '08122222003',
                'email'        => 'kaprod.kimia@gmail.com',
            ],
            [
                'nip'          => '198004042008041004',
                'nama_kaprod'  => 'apt. Rina Marlina',
                'jurusan'      => 'Farmasi',
                'alamat'       => 'Jl. Pendidikan No. 4',
                'telp'         => '08122222004',
                'email'        => 'kaprod.farmasi@gmail.com',
            ],
        ];

        foreach ($dataKaprod as $data) {

            /**
             * 1️⃣ Ambil jurusan
             */
            $jurusan = Jurusan::where('nama_jurusan', $data['jurusan'])->first();

            if (!$jurusan) {
                throw new \Exception("Jurusan {$data['jurusan']} tidak ditemukan");
            }

            /**
             * 2️⃣ Buat / ambil user Kaprodi
             */
            $user = User::firstOrCreate(
                ['username' => $data['nip']],
                [
                    'name'     => $data['nama_kaprod'],
                    'email'    => $data['email'],
                    'password' => Hash::make('kaprod123'),
                    'role_id'  => 1, // PASTIKAN role_id 1 = Kaprodi
                ]
            );

            /**
             * 3️⃣ Buat / ambil data Kaprodi
             */
            Kaprod::firstOrCreate(
                ['nip' => $data['nip']],
                [
                    'user_id'    => $user->id,
                    'nama_kaprod'=> $data['nama_kaprod'],
                    'alamat'     => $data['alamat'],
                    'telp'       => $data['telp'],
                    'jurusan_id' => $jurusan->id,
                ]
            );
        }
    }
}
