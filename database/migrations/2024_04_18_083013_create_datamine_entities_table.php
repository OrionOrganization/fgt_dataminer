<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatamineEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datamine_entities', function (Blueprint $table) {
            $table->id();
            $table->string('key')->nullable();
            $table->string('key_parcial')->nullable();
            $table->string('type_entity')->nullable();
            $table->integer('type_tax_regime')->nullable();
            $table->integer('code_ibge')->nullable();
            $table->text('obs')->nullable();
            $table->json('extra')->nullable();
            $table->json('address')->nullable();
            $table->timestamps();

            $table->unique(['code_ibge']);
            $table->unique(['type_tax_regime']);
            $table->unique(['key']);
            $table->unique(['key_parcial']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('datamine_entities');
    }
}
