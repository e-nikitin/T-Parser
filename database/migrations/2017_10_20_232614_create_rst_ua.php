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
            $table->date('upload_date');
            $table->string('carcase_type');
            $table->integer('t_km')->default(0);
            $table->integer('service_id');
            $table->string('phone',20)->nullable();
            $table->string('photo',100)->default('nophoto.png');
            $table->string('link', 100);
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
