<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Pengguna dummy (password semuanya: "password")
        User::factory()->create(['name' => 'Budi', 'email' => 'budi@flipplay.test']);
        User::factory()->create(['name' => 'Sari', 'email' => 'sari@flipplay.test']);
        User::factory()->create(['name' => 'Andi', 'email' => 'andi@flipplay.test']);

        // Media dummy
        Media::factory(15)->create();
    }
}
