<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'E-Books'],
            ['name' => 'Software Licenses'],
            ['name' => 'Online Courses'],
            ['name' => 'Music & Audio'],
            ['name' => 'Graphic Design Templates'],
            ['name' => 'Stock Photos'],
            ['name' => 'Website Themes'],
            ['name' => 'Resume & CV Templates'],
            ['name' => 'Podcast Episodes'],
            ['name' => 'Subscription Services'],
        ];

        DB::table('categories')->insert($categories);
    }
}
