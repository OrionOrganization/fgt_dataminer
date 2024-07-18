<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOportunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oportunities', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->foreignId('company_id')
                ->nullable()
                ->constrained()
                ->onDelete('set null');

            $table->foreignId('contact_id')
                ->nullable()
                ->constrained()
                ->onDelete('set null');

            $table->integer('status')->default(0);

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->onDelete('set null');

            $table->text('obs')->nullable();
            $table->date('date')->nullable();

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
        Schema::dropIfExists('oportunities');
    }
}
