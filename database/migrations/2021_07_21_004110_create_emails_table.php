<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->string('type')->unique();
            $table->text('message');
            $table->integer('day') ->nullable();
            $table->integer('month')->nullable();
            $table->integer('day2') ->nullable();
            $table->integer('month2')->nullable();
            $table->boolean('enable_sending');
            $table->boolean('send_on_schedule')->nullable();;
            $table->boolean('send_on_schedule2')->nullable();;
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
        Schema::dropIfExists('emails');
    }
}
