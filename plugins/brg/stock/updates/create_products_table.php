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
            $table->double('price')->nullable();
            $table->double('silver_quantity')->nullable();
            $table->double('case_price')->nullable();
            $table->boolean('production_status')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('brg_stock_products');
    }
}

