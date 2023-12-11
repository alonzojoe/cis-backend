<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_history', function (Blueprint $table) {
            $table->id();
            $table->integer('unremarkable')->nullable();
            $table->integer('hcvd')->nullable();
            $table->integer('chd')->nullable();
            $table->integer('cva')->nullable();
            $table->integer('gut_disease')->nullable();
            $table->integer('blood_dyscrasia')->nullable();
            $table->integer('allergy')->nullable();
            $table->integer('dm')->nullable();
            $table->integer('git_disease')->nullable();
            $table->integer('pulmo_disease')->nullable();
            $table->integer('ca')->nullable();
            $table->longText('other_findings')->nullable();
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
        Schema::dropIfExists('family_history');
    }
};
