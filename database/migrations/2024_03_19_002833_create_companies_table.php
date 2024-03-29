<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('nickname');
            $table->string('cnpj')->nullable()->unique();
            $table->string('social_reason')->nullable();
            $table->integer('category')->nullable();
            $table->integer('origin')->nullable();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->onDelete('set null');
            $table->integer('setor')->nullable();
            $table->longText('description');
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->string('site')->nullable();
            $table->json('address')->nullable();
            $table->integer('tax_regime')->nullable();
            $table->integer('employees_quantity')->nullable();
            $table->string('cnae')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
