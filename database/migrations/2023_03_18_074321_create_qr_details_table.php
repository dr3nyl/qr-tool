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
        Schema::create('qr_details', function (Blueprint $table) {
            $table->id();
            $table->string('part_number');
            $table->string('date_code');
            $table->string('vendor_code');
            $table->string('qr_details');
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('isDeleted');
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
        Schema::dropIfExists('qr_details');
    }
};
