<?php


use Illuminate\Database\Seeder;
use App\Libs\Autoria\AutoriaAPI;
use Illuminate\Support\Facades\DB;

class CarModelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->AutoriaAPI = new AutoriaAPI();

        $passengerCars=$this->AutoriaAPI->getAllMarksWithIds(1); //Марки легковых авто
        foreach ($passengerCars as $passengerCar) {
            DB::table('car_models')->insert([
                'id' => $passengerCar['value'],
                'model' => $passengerCar['name'],
                'carcas_type' => 1,
            ]);
        }

                $cargoCars=$this->AutoriaAPI->getAllMarksWithIds(6); //Марки легковых авто
                foreach ($cargoCars as $cargoCar) {
                    DB::table('car_models')->insert([
                        'id' => $cargoCar['value'],
                        'model' => $cargoCar['name'],
                        'carcas_type' => 6,
                    ]);
                }

    }
}
