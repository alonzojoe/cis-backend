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
        Schema::create('past_history', function (Blueprint $table) {
            $table->id();
            $table->integer('unremarkable')->nullable();
            $table->integer('blood_disease')->nullable();
            $table->integer('asthma')->nullable();
            $table->integer('hypertension')->nullable();
            $table->integer('cva')->nullable();
            $table->integer('gut_disease')->nullable();
            $table->integer('git_disease')->nullable();
            $table->integer('pulmo_disease')->nullable();
            $table->longText('previous_or')->nullable();
            $table->longText('previous_hospitalization')->nullable();
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
        Schema::dropIfExists('past_history');
    }
};
