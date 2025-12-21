<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mitra;

class MitraSeeder extends Seeder
{
    public function run(): void
    {
        $mitra = [
            // Multimedia
            [
                'nama_mitra' => 'PT Kreatif Media Nusantara',
                'bidang'     => 'Desain Grafis & Multimedia',
                'alamat'    => 'Jl. Merdeka No. 12, Bandung',
                'pl'        => 'Andi Pratama',
                'telp'      => '081234567801',
            ],
            [
                'nama_mitra' => 'CV Digital Vision Studio',
                'bidang'     => 'Produksi Video & Animasi',
                'alamat'    => 'Jl. Soekarno Hatta No. 45, Bandung',
                'pl'        => 'Rina Wulandari',
                'telp'      => '081234567802',
            ],

            // Akuntansi
            [
                'nama_mitra' => 'PT Sinar Jaya Abadi',
                'bidang'     => 'Akuntansi & Keuangan',
                'alamat'    => 'Jl. Asia Afrika No. 88, Bandung',
                'pl'        => 'Budi Santoso',
                'telp'      => '081234567803',
            ],
            [
                'nama_mitra' => 'Kantor Akuntan Publik Wijaya',
                'bidang'     => 'Jasa Akuntansi',
                'alamat'    => 'Jl. Diponegoro No. 10, Bandung',
                'pl'        => 'Dewi Lestari',
                'telp'      => '081234567804',
            ],

            // Kimia Industri
            [
                'nama_mitra' => 'PT Kimia Sejahtera',
                'bidang'     => 'Industri Kimia',
                'alamat'    => 'Kawasan Industri Cikarang',
                'pl'        => 'Hendra Saputra',
                'telp'      => '081234567805',
            ],
            [
                'nama_mitra' => 'PT Industri Kimia Prima',
                'bidang'     => 'Pengolahan Bahan Kimia',
                'alamat'    => 'Jl. Industri Raya No. 5, Bekasi',
                'pl'        => 'Siti Aminah',
                'telp'      => '081234567806',
            ],

            // Farmasi
            [
                'nama_mitra' => 'PT Farma Medika Indonesia',
                'bidang'     => 'Farmasi',
                'alamat'    => 'Jl. Kesehatan No. 20, Jakarta',
                'pl'        => 'Dr. Rudi Hartono',
                'telp'      => '081234567807',
            ],
            [
                'nama_mitra' => 'Apotek Sehat Sentosa',
                'bidang'     => 'Pelayanan Kefarmasian',
                'alamat'    => 'Jl. Sudirman No. 15, Bandung',
                'pl'        => 'apt. Lina Marlina',
                'telp'      => '081234567808',
            ],
        ];

        foreach ($mitra as $data) {
            Mitra::create($data);
        }
    }
}
