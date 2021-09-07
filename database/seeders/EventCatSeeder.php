<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Seeder;

class EventCatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Categories $categories)
    {
        $categories->create([
            'cat_name'  => ucfirst('Desain Grafis'),
            'slug'      => str_replace([' ', '\''], '-', 'Desain Grafis'),
        ]);
        $categories->create([
            'cat_name'      => 'Bawaan',
            'slug'          => 'bawaan',
        ]);
    }
}
