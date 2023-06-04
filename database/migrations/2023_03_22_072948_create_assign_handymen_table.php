<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignHandymenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assign_handymen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOneDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOneDelete();
            $table->foreignId('provider_id')->constrained('providers')->cascadeOneDelete();
            $table->foreignId('handyman_id')->constrained('handymen')->cascadeOneDelete();
            $table->foreignId('service_id')->constrained('services')->cascadeOneDelete();
            $table->tinyInteger('status')->nullable();
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
        Schema::dropIfExists('assign_handymen');
    }
}
