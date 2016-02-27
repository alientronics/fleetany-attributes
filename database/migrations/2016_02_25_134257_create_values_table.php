<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('values', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->char('entity_key', 10);
            $table->integer('entity_id')->unsigned();
            $table->integer('attribute_id')->unsigned();
            $table->foreign('attribute_id')->references('id')->on('keys');
            $table->primary(['entity_key', 'entity_id', 'attribute_id']);
            $table->string('value');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('values');
    }
}
