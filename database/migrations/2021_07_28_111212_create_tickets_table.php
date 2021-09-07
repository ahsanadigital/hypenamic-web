<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('id_ticket', 255)->nullable()->unique();

            $table->string('ticket_name')->nullable();
            $table->bigInteger('stok', false, true)->nullable();
            $table->text('description_tiket')->nullable();
            $table->string('event_id', 255)->nullable();
            $table->integer('price')->nullable();
            $table->dateTime('end_date')->nullable();

            $table->enum('expiry_on', ['besok', 'hari_ini', 'kegiatan'])->nullable();
            $table->enum('status', ['open', 'closed'])->nullable();
            $table->enum('single_transaction', ['true', 'false'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
