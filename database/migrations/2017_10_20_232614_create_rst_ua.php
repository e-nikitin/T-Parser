<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRstUa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rst_ua', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rst_model_id');
            $table->float('price');
            $table->integer('year_issue')->nullable();
            $table->double('engine');
            $table->string('kpp',20);
            $table->string('carcase_type');
            $table->string('region',20);
            $table->date('upload_date');
            $table->integer('t_km')->default(0);
            $table->integer('service_id');
            $table->string('phone',140)->nullable();
            $table->string('photo',70)->default('nophoto.png');
            $table->string('link', 150);
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
        Schema::dropIfExists('rst_ua');
    }
}
