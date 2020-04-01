<?php namespace BergueJewelry\Stock\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('berguejewelry_stock_products', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->bigInteger('collection_id')->unsigned()->nullable();
            $table->double('pre_sell_cost')->nullable();
            $table->boolean('status')->default(false);
            $table->boolean('stop_selling')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('berguejewelry_stock_products');
    }
}

