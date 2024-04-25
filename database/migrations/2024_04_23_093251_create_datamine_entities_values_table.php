<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatamineEntitiesValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datamine_entities_values', function (Blueprint $table) {
            $table->integer('id')->index()->unique();
            $table->bigInteger('value_all')->nullable();
            $table->bigInteger('value_indicador_ajuizado')->nullable();
            $table->bigInteger('value_n_indicador_ajuizado')->nullable();
            $table->bigInteger('value_type_tax_benefit')->nullable();
            $table->bigInteger('value_type_in_collection')->nullable();
            $table->bigInteger('value_type_in_negociation')->nullable();
            $table->bigInteger('value_type_guarantee')->nullable();
            $table->bigInteger('value_type_suspended')->nullable();
            $table->bigInteger('value_type_others')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('datamine_entities_values');
    }
}
