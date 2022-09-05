<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('kode',255);
            $table->string('kode_panggil',255);
            $table->string('judul',255);
            $table->string('penulis',255);
            $table->string('penulis_tambahan',255)->nullable();
            $table->string('penerbit',255)->nullable();
            $table->string('kelas')->nullable();
            $table->string('rak')->nullable();
            $table->string('jurusan')->nullable();
            $table->string('tags')->nullable();
            $table->string('abstrak')->nullable();
            $table->integer('tahun_terbit')->nullable();
            $table->string('cover',255)->nullable();
            $table->string('kategori')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
