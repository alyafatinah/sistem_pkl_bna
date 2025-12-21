<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jadwal;
use App\Models\Jurusan;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        /**
         * DATA JADWAL PKL PER JURUSAN
         */
        $dataJadwal = [
            [
                'angkatan' => '2026/2027',
                'jurusan'  => 'Multimedia',
                'pembekalan' => '2026-01-10',
                'pengantaran' => '2026-02-01',
                'monitoring' => '2026-03-15',
                'penjemputan' => '2026-05-10',
            ],
            [
                'angkatan' => '2026/2027',
                'jurusan'  => 'Akuntansi',
                'pembekalan' => '2026-01-12',
                'pengantaran' => '2026-02-03',
                'monitoring' => '2026-03-17',
                'penjemputan' => '2026-05-12',
            ],
            [
                'angkatan' => '2026/2027',
                'jurusan'  => 'Kimia Industri',
                'pembekalan' => '2026-01-15',
                'pengantaran' => '2026-02-05',
                'monitoring' => '2026-03-20',
                'penjemputan' => '2026-05-15',
            ],
            [
                'angkatan' => '2026/2027',
                'jurusan'  => 'Farmasi',
                'pembekalan' => '2026-01-18',
                'pengantaran' => '2026-02-08',
                'monitoring' => '2026-03-22',
                'penjemputan' => '2026-05-18',
            ],
        ];

        foreach ($dataJadwal as $data) {

            /**
             * 1️⃣ Ambil jurusan
             */
            $jurusan = Jurusan::where('nama_jurusan', $data['jurusan'])->first();

            if (!$jurusan) {
                throw new \Exception("Jurusan {$data['jurusan']} tidak ditemukan");
            }

            /**
             * 2️⃣ Simpan jadwal (aman duplicate)
             */
            Jadwal::firstOrCreate(
                [
                    'angkatan'   => $data['angkatan'],
                    'jurusan_id' => $jurusan->id,
                ],
                [
                    'pembekalan' => $data['pembekalan'],
                    'pengantaran'=> $data['pengantaran'],
                    'monitoring' => $data['monitoring'],
                    'penjemputan'=> $data['penjemputan'],
                ]
            );
        }
    }
}
