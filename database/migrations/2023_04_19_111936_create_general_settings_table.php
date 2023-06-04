<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('website_name')->nullable();
            $table->text('contact_details')->nullable();
            $table->text('web_description')->nullable();
            $table->text('copyright_info')->nullable();
            $table->string('mobile')->nullable();
            $table->string('service_location')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('icon')->nullable();
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
        Schema::dropIfExists('general_settings');
    }
}
