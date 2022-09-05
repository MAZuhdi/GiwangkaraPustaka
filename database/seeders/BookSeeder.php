<?php

namespace Database\Seeders;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->insert([
            'kode' => Str::random(10),
            'kode_panggil' => Str::random(10),
            'judul' => Str::random(10),
            'penulis' => Str::random(10),
            'tahun_terbit' => 2022,
            'penerbit' => Str::random(10),
        ]);
    }
}
