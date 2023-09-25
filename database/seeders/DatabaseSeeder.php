<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $serviceTemplate = [
            'Магазин',
            'Приложение',
            'Доставка',
        ];
        foreach ($serviceTemplate as $service)
        {
             \App\Models\Service::create([
                 'title' => $service
             ]);
        }
    }
}
