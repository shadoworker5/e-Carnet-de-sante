<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableForAllPatient extends Migration
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
            $table->foreignId('user_id')->constrained();
            $table->string('code_patient')->unique();
            $table->string('full_name');
            $table->date('birthday');
            $table->enum('genre', ['M', 'F']);
            $table->string('name_father')->default(null);
            $table->string('name_mother')->default(null);
            $table->string('name_mentor')->default(null);
            $table->string('helper_contact');
            $table->string('helper_email')->default(null);
            $table->string('other_field')->nullable();
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
        Schema::dropIfExists('patients');
    }
}
