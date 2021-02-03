<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePatientVaccinates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_vaccinates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('patient_id')->constrained();
            $table->foreignId('vaccine_calendar_id')->constrained();
            $table->date('date_vacination');
            $table->time('time_vacination');
            $table->string('lot_number_vacine');
            $table->date('validity_vacine')->nullable();
            $table->string('name_doctor');
            $table->string('doctor_contact');
            $table->string('rappelle')->nullable();
            $table->boolean('vacine_status')->default(false);
            $table->string('path_capture')->nullable();
            $table->string('others_field')->nullable();
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
        Schema::dropIfExists('patient_vaccinates');
    }
}
