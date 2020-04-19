<?php namespace Brg\Stock\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('brg_stock_products', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->bigInteger('collection_id')->unsigned()->nullable();
            $table->double('cost')->nullable();
            $table->double('price')->nullable();
            $table->double('quantity')->nullable();
            $table->double('quantity_alert')->nullable();
            $table->double('silver_quantity')->nullable();
            $table->double('labour_cost')->nullable();
            $table->boolean('production_status')->default(false);
            $table->boolean('stop_selling')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('brg_stock_products');
    }
}

