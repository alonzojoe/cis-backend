<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('vital_signs', function (Blueprint $table) {
            $table->string('height')->nullable()->change();
            $table->string('weight')->nullable()->change();
            $table->string('bmi')->nullable()->change();
            $table->string('bp_f')->nullable()->change();
            $table->string('bp_s')->nullable()->change();
            $table->string('oxygen_saturation')->nullable()->change();
            $table->string('respiratory_rate')->nullable()->change();
            $table->string('pulse_rate')->nullable()->change();
            $table->string('cbg')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
