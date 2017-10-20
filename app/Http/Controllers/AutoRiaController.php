<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\Autoria\AutoriaAPI as AutoriaAPI;
use \Symfony\Component\DomCrawler\Crawler as Crawler;

class AutoRiaController extends Controller
{

    public function index() {
    //dd('hello!');
        $html = file_get_contents('http://allboxing.ru/news-archive/5/201703?page=5');
        $crawler = new Crawler($html);
      dd($crawler );
        $AutoriaAPI = new AutoriaAPI();
        $AutoriaAPI->index();
    }


    private static function getPageTopicsUrls($pageNumber) {
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
    }


}
