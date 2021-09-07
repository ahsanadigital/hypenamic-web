<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('event_id', 255)->unique();
            $table->timestamps();

            $table->longText('event_banner')->nullable();
            $table->longText('thumbnail')->nullable();

            $table->string('event_name')->nullable();                       // Bana Kegiatan
            $table->text('event_desc')->nullable();                         // Deskripsi Kegiatan
            $table->text('event_desc_short')->nullable();                   // Deskripsi Kegiatan
            $table->text('event_tos')->nullable();                          // Aturan Kegiatan
            $table->string('id_user', 255)->nullable();                            // Pembuat Event
            $table->date('start_date')->nullable();                         // Tanggal Mulai Event
            $table->date('end_date')->nullable();                           // Tanggal Selesai
            $table->time('start_time')->nullable();                         // Jam kegiatan mulai
            $table->time('end_time')->nullable();                           // Jam Kegiatan berakhir

            $table->string('category', 255)->nullable();                    // Kategori

            $table->string('alamat', false, false)->nullable();
            $table->bigInteger('kelurahan', false, false)->nullable();
            $table->integer('kecamatan', false, false)->nullable();
            $table->integer('kabupaten', false, false)->nullable();
            $table->integer('provinsi', false, false)->nullable();

            $table->string('url')->nullable();

            $table->enum('event_do', ['offline', 'online'])->nullable();
            $table->boolean('highlight')->nullable()->default(false);
            $table->enum('event_type', ['free', 'bayar'])->nullable();
            $table->enum('status', ['open', 'closed'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
