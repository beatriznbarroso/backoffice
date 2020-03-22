<?php namespace Brg\Stock\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateComponentsTable extends Migration
{
    public function up()
    {
        Schema::create('powerparity_brg_components', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->bigInteger('profile_id')->nullable()->unsigned()->index();
            $table->float('min_interest')->nullable();
            $table->float('max_interest')->nullable();
            $table->integer('min_term')->nullable();
            $table->integer('max_term')->nullable();
            $table->integer('balance_percentage')->nullable();
            $table->boolean('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('powerparity_crowdlending_auto_investments');
    }
}

