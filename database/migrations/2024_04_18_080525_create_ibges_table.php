<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIbgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ibges', function (Blueprint $table) {
            $table->id();
            $table->integer('code_ibge')->nullable();
            $table->integer('distrito_id')->nullable();
            $table->string('distrito')->nullable();
            $table->string('municipio')->nullable();
            $table->string('uf_sigla')->nullable();
            $table->string('uf_nome')->nullable();
            $table->integer('populacao')->nullable();
            $table->json('response')->nullable();

            $table->index('code_ibge');

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
        Schema::dropIfExists('ibges');
    }
}
