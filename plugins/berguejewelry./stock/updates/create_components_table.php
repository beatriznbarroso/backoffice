<?php namespace BergueJewelry\Stock\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateComponentsTable extends Migration
{
    public function up()
    {
        Schema::create('berguejewelry_stock_components', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('category')->nullable();
            $table->string('reference')->nullable();
            $table->double('cost')->nullable();
            $table->double('weight')->nullable();
            $table->double('quantity_alert')->nullable();
            $table->string('supplier_name')->nullable();
            $table->boolean('is_recyclable')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('berguejewelry_stock_components');
    }
}

