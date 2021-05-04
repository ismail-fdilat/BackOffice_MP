<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('shops')) {
            // The "shops" table exists...
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                // $table->bigInteger('shop_id')->unsigned()->index();
                $table->unsignedBigInteger('shop_id')->index();
                $table->foreign('shop_id')
            ->references('id')
            ->on('shops')
            ->onUpdate('cascade')
            ->onDelete('cascade');
                $table->string('name');
                $table->string('detail');
                $table->integer('price');
                $table->integer('stock');
                $table->integer('discount');
                $table->integer('quantity');

                $table->boolean('status');
                $table->string('provider');

                $table->float('weight');
                $table->string('hero_image')->nullable();
                $table->timestamps();
            });
        }
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
