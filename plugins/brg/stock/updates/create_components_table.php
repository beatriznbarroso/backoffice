<?php namespace Brg\Stock\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateComponentsTable extends Migration
{
    public function up()
    {
        Schema::create('brg_stock_components', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('category')->nullable();
            $table->string('reference')->nullable();
            $table->float('cost')->nullable();
            $table->float('weight')->nullable();
            $table->float('quantity')->nullable();
            $table->float('quantity_alert')->nullable();
            $table->string('supplier_name')->nullable();
            $table->bigInteger('category_id')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('brg_stock_components');
    }
}

