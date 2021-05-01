<?php namespace Brg\Stock\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('brg_stock_histories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('component_id')->unsigned();
            // $table->integer('product_id')->nullable();
            $table->string('component_reference')->nullable();
            $table->string('component_name')->nullable();
            // $table->string('product_code')->nullable();
            // $table->string('product_name')->nullable();
            $table->string('type')->nullable();
            $table->double('component_used_quantity')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('brg_stock_histories');
    }
}
