<?php
namespace App\TParser\ParserAvailable;


use App\TParser\AbstractParser;
use Symfony\Component\DomCrawler\Crawler;

class RSTParser extends AbstractParser
{
    protected $url = 'http://rst.ua/oldcars/?task=newresults&make%5B%5D=0&year%5B%5D=0&year%5B%5D=0&price%5B%5D=0&price%5B%5D=0&engine%5B%5D=0&engine%5B%5D=0&gear=0&fuel=0&drive=0&condition=0&from=sform&start=1';
    protected $baseUrl = 'http://rst.ua';

    public function getAds(){
        $links = $this->initCrawler($this->url)->filter('div.rst-ocb-i')->each(function (Crawler $node){
            $r = null;
            if(str_contains($node->attr('id'),'rst-ocid-')) {
                $r = $node->filter('a')->each(function (Crawler $node) {
                    return $this->baseUrl . $node->attr('href');
                });
            }
            return empty($r) ? null : head($r);
        });
        $links = collect($links)->filter(function ($link){
            return !empty($link);
        });

        // Ссылки по которым можно получить нужную информациюю - готовы.
        // Формирую колекцию обьявлений со страниц
        $ads = collect();
        $links->each(function($link) use ($ads){
            $ads->push($this->initCrawler($link)->filter('#rst-page-oldcars-item')->each(function (Crawler $node){
                // Вытягиваю фото
                $photo = $node->filter('#rst-page-oldcars-item-photos-block')->each(function (Crawler $node){
                    $r = $node->filter('a')->reduce(function (Crawler $node, $i){
                        return $i == 1;
                    })->each(function (Crawler $node){
                        return $node->attr('href');
                    });
                    return head($r);
                });

                dd($photo);


            }));
        });
        //dd($links);
    }

    public function saveAds()
    {

    }


}