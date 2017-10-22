<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\Autoria\AutoriaAPI as AutoriaAPI;
use \Symfony\Component\DomCrawler\Crawler as Crawler;
use Illuminate\Support\Facades\DB;




class AutoRiaController extends Controller
{
    protected $AutoriaAPI;

    public function index() {

        dd(new CarModelsTableSeeder());


      $this->AutoriaAPI = new AutoriaAPI();
    //   $cars =   $this->AutoriaAPI->getCarIdsByParams(array('top'=>'2'));

     //   $cars = $cars['result']['search_result']['ids'];

     //   $cars = array_slice($cars,0,5);
       // dump($cars);
      // dd($this->AutoriaAPI->getCarInfoById(20621400));
      //dd($this->AutoriaAPI->getAllMarksWithIds(6));

        $passengerCars=$this->AutoriaAPI->getAllMarksWithIds(1); //Марки легковых авто
        foreach ($passengerCars as $passengerCar) {
            DB::table('car_models')->insert([
                'id' => $passengerCar['value'],
                'model' => $passengerCar['name'],
                'carcas_type' => 1,
            ]);
        }

      /*  foreach ($cars as $car) {
            dump($this->AutoriaAPI->getCarInfoById($car)['markName']);
        }*/





        //getCarInfoById

    }





    /*private static function getPageTopicsUrls($pageNumber) {
        self::$pageNews = array();
        $html = file_get_contents('http://allboxing.ru/news-archive/5/201703?page='.$pageNumber);
        $crawler = new Crawler($html);

        $crawler->filter('div.block-news-all-lists li.views-row')->each(function ($node, $i) {
            $topic = $node->filter('a')->first()->each(function (Crawler $node, $i) {
                return $node->attr('href');
            });
            array_push(self::$pageNews,$topic[0]);
        });
        $pageNews = self::$pageNews;
        return $pageNews;
    }*/




}
