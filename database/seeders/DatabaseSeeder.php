<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Document;
use App\Models\DocumentUser;
use App\Models\DocumentVersion;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(300)->create();
//        $maxVersion = 4;
//        for ($version = 1; $version <= $maxVersion; $version++) {
//            Document::factory(300)->create([
//                'current_version' => $version
//            ]);
//        }
        Document::factory(1200)->create();
        DocumentVersion::factory(2500)->create();
        DocumentUser::factory(8400)->create();
    }
}
