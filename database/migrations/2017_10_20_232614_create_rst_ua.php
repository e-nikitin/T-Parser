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
            $table->integer('brand_id');
            $table->integer('model_id');
            $table->float('price');
            $table->string('photo',100)->default('nophoto.png');
            $table->string('link', 100);
            $table->date('year_issue')->nullable();
            $table->integer('t_km')->default(0);
            $table->integer('service_id');
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
