<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOneDelete();
            $table->foreignId('category_id')->constrained('categories')->cascadeOneDelete();
            $table->integer('handyman_id')->dafult(0)->nullable();
            $table->foreignId('provider_id')->constrained('providers')->cascadeOneDelete();
            $table->foreignId('service_id')->constrained('services')->cascadeOneDelete();
            $table->date('date_time');
            $table->float('price');
            $table->string('status')->default('Pandding');
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
        Schema::dropIfExists('bookings');
    }
}
