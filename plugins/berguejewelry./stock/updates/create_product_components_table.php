<?php namespace BergueJewelry\Stock\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateProductComponentsTable extends Migration
{
    public function up()
    {
        Schema::create('berguejewelry_stock_product_components', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('component_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->primary(['component_id', 'product_id']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('berguejewelry_stock_product_components');
    }
}