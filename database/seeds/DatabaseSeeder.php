<?php

use Illuminate\Database\Seeder;
use App\Libs\Autoria\AutoriaAPI;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ModelSeeder::class
        ]);
    }




}

class ModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $autoriaAPI = new AutoriaAPI();

        $passengerCars=$autoriaAPI->getAllMarksWithIds(1); //Марки легковых авто
        foreach ($passengerCars as $passengerCar) {
            DB::table('car_brands')->insert([
                'id' => $passengerCar['value'],
                'brand' => $passengerCar['name'],
            ]);
        }

        $cargoCars=$autoriaAPI->getAllMarksWithIds(6); //Марки легковых авто
        foreach ($cargoCars as $cargoCar) {
            DB::table('car_brands')->insert([
                'id' => $cargoCar['value'],
                'brand' => $cargoCar['name'],
            ]);
        }
    }
}

