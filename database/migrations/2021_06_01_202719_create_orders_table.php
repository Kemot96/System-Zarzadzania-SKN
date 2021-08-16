<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reports_id');
            $table->foreign('reports_id')->references('id')->on('reports')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('type')->nullable();
            $table->string('quantity')->nullable();
            $table->double('gross', 12,2)->nullable();
            $table->string('term')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
