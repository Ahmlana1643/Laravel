<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::insert([
            [
                'uuid' => Str::uuid(),
                'name' => 'Wedding Party',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quidem.',
                'price' => 5000000,
                'image' => 'gambar1.png',
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Birthday Party',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quidem.',
                'price' => 10000000,
                'image' => 'gambar2.png',
            ],
        ]);
    }
}
