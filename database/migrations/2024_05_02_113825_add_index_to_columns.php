<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('datamine_divida_aberta_raws', function (Blueprint $table) {
        //     $table->index(['created_at']);
        // });

        // Schema::table('datamine_entities', function (Blueprint $table) {
        //     $table->index(['created_at']);
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('datamine_divida_aberta_raws', function (Blueprint $table) {
        //     $table->dropIndex(['created_at']);
        // });

        // Schema::table('datamine_entities', function (Blueprint $table) {
        //     $table->dropIndex(['created_at']);
        // });
    }
}
