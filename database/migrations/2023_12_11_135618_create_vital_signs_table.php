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
        Schema::create('vital_signs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consultation_id')->nullable();
            $table->decimal('height', 8, 2)->default(0.00);
            $table->decimal('weight', 8, 2)->default(0.00);
            $table->decimal('bmi', 8, 2)->default(0.00);
            $table->decimal('bp_f', 8, 2)->default(0.00);
            $table->decimal('bp_s', 8, 2)->default(0.00);
            $table->decimal('oxygen_saturation', 8, 2)->default(0.00);
            $table->decimal('respiratory_rate', 8, 2)->default(0.00);
            $table->decimal('pulse_rate', 8, 2)->default(0.00);
            $table->decimal('cbg', 8, 2)->default(0.00);
            $table->timestamps();

            $table->foreign('consultation_id')->references('id')->on('consultation_history');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vital_signs');
    }
};
