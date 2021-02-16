<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableOfAllCountries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contries', function (Blueprint $table) {
            $table->id();
            $table->string('code_pays2');
            $table->string('code_pays3');
            $table->string('code_lang');
            $table->string('code_tel');
            $table->string('nom_fr');
            $table->string('nom_en');
            $table->string('langues');
            $table->string('other_fields')->nullable();;
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
        Schema::dropIfExists('contries');
    }
}
