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
        Schema::create('social_history', function (Blueprint $table) {
            $table->id();
            $table->longText('smoking')->nullable();
            $table->longText('alcohol_intake')->nullable();
            $table->longText('betel_nut_chewing')->nullable();
            $table->longText('drug_food_allergy')->nullable();
            $table->longText('others')->nullable();
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
        Schema::dropIfExists('social_history');
    }
};
