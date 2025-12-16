<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // ← WAJIB DITAMBAHKAN
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['id' => 1, 'nama' => 'kaprodi'],
            ['id' => 2, 'nama' => 'humas'],
            ['id' => 3, 'nama' => 'guruPembimbing'],
            ['id' => 4, 'nama' => 'siswa'],
            ['id' => 5, 'nama' => 'admin'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['id' => $role['id']],
                ['nama' => $role['nama']]
            );
        }
    }
}
