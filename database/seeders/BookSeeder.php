<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('books')->insert([
            'name' => 'Book name',
            'author' => 'John Doe',
            'publisher' => 'publisher',
            'summary' => 'lorem ipsum dolor sit amet',
            'read_page' => 10,
            'total_page' => 100,
            'finished' => false
        ]);
    }
}
