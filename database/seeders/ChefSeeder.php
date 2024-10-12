<?php

namespace Database\Seeders;

use App\Models\Chef;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ChefSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Chef::insert([
            [
                'uuid' => Str::uuid(),
                'name' => 'John Doe',
                'position' => 'Master Chef',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quidem.',
                'insta_link' => 'https://www.instagram.com/',
                'linked_link' => 'https://www.linkedin.com/',
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Jane Doe',
                'position' => 'Patissier',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quidem.',
                'insta_link' => 'https://www.instagram.com/',
                'linked_link' => 'https://www.linkedin.com/',
            ],
        ]);
    }
}
