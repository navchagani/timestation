<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_settings', function (Blueprint $table) {
            $table->id();
            $table->string('business_id', 255)->nullable();
            $table->string('business_name', 255)->nullable();
            $table->string('address', 555)->nullable();
            $table->string('area', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('attendance_mode', 255)->nullable();
            $table->string('GPS_location_tagging', 25)->nullable();
            $table->string('covid_19_screening', 25)->nullable();
            $table->string('time_rounding', 255)->nullable();
            $table->string('TimeRounding_Display', 25)->nullable();
            $table->string('DateFormat', 255)->nullable();
            $table->string('TimeFormat', 255)->nullable();
            $table->string('HoursFormat', 255)->nullable();
            $table->string('automaticTimeDeduction', 255)->nullable();
            $table->string('automaticTimeDeductionThreshold', 255)->nullable();
            $table->string('DefaultReportDateRange', 255)->nullable();
            $table->string('DefaultReportDateRange_Today', 255)->nullable();
            $table->string('Card_Text_Size', 255)->nullable();
            $table->string('Card_field_1', 255)->nullable();
            $table->string('Card_field_2', 255)->nullable();
            $table->string('Card_field_3', 255)->nullable();
            $table->string('Card_field_4', 255)->nullable();
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
        Schema::dropIfExists('business_settings');
    }
}
