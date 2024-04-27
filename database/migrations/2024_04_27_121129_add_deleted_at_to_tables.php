<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::table('oportunities', function (Blueprint $table) {
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
