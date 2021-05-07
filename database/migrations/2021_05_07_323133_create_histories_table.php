<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->bigIncrements('id_history');
            $table->unsignedBigInteger('id_stock');
            $table->unsignedBigInteger('id_supplier')->nullable();
            $table->unsignedBigInteger('id_pelanggan')->nullable();
            $table->string('description');
            $table->double('stock');
            $table->integer('harga');
            $table->enum('type', ['stock_in', 'stock_out']);
            $table->integer('total')->nullable();
            $table->timestamps();

            $table->foreign('id_stock')->references('id_stock')->on('stocks')->onDelete('cascade');
            $table->foreign('id_supplier')->references('id_supplier')->on('suppliers')->onDelete('cascade');
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('histories');
    }
}
