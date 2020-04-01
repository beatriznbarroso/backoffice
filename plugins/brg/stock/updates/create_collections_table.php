<?php namespace Brg\Stock\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCollectionsTable extends Migration
{
    public function up()
    {
        Schema::create('brg_stock_collections', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->boolean('status')->default(false);
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('brg_stock_collections');
    }
}
