<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku')->unique();
            $table->integer('qty');
            $table->integer('reserved_qty');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->double('grand_total', 10, 2);
            $table->string('status');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });

        Schema::create('orders_item', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->string('sku');
            $table->integer('qty');
            $table->timestamp('deleted_at')->nullable();
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
        //
    }
}
