<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('id_user', 255)->unique();

            $table->string('username');                         // Nama Pengguna
            $table->string('email')->unique();                  // Email Pengguna (nanti diverifikasi)
            $table->string('number_phone', 16)->unique();       // Nomor HP pengguna
            $table->string('password');                         // Kata Sandi pengguna

            $table->string('fullname')->nullable();
            $table->string('institution')->nullable();
            $table->longText('foto_profil')->nullable();
            $table->longText('banner_eo')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('facebook')->nullable();
            $table->string('whatsapp')->nullable();

            $table->enum('status', ['on', 'off'])->nullable();
            $table->enum('type', ['user', 'admin'])->nullable()->default('user');

            $table->longText('alamat')->nullable();
            $table->bigInteger('kelurahan')->nullable();
            $table->mediumInteger('kecamatan')->nullable();
            $table->integer('kabupaten')->nullable();
            $table->integer('provinsi')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
