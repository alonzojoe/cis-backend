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
        Schema::table('vital_signs', function (Blueprint $table) {
            $table->decimal('temperature', 8, 2)->default(0.00)->after('oxygen_saturation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vital_signs', function (Blueprint $table) {
            //
        });
    }
};
