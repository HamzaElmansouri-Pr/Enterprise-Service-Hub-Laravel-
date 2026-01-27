<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WebsiteDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(StructureSeeder::class);
    }
}
