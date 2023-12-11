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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('lname')->nullable();
            $table->string('fname')->nullable();
            $table->string('mname')->nullable();
            $table->string('birthdate')->nullable();
            $table->integer('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('contact_no')->nullable();
            $table->longText('address')->nullable();
            $table->longText('vaccination')->nullable();
            $table->unsignedBigInteger('past_history_id')->nullable();
            $table->unsignedBigInteger('family_history_id')->nullable();
            $table->unsignedBigInteger('social_history_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->foreign('past_history_id')->references('id')->on('past_history');
            $table->foreign('family_history_id')->references('id')->on('family_history');
            $table->foreign('social_history_id')->references('id')->on('social_history');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
};
