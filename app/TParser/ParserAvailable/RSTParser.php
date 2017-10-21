<?php
namespace App\TParser\ParserAvailable;


use App\TParser\AbstractParser;
use Symfony\Component\DomCrawler\Crawler;

class RSTParser extends AbstractParser
{
    protected $url = 'http://rst.ua/oldcars/?task=newresults&make%5B%5D=0&year%5B%5D=0&year%5B%5D=0&price%5B%5D=0&price%5B%5D=0&engine%5B%5D=0&engine%5B%5D=0&gear=0&fuel=0&drive=0&condition=0&from=sform';
    protected $baseUrl = 'http://rst.ua';

    public function getAds(){
        $ads = collect();
        $crawler = $this->initCrawler($this->url);
        $crawler->filter('div.rst-ocb-i')->each(function (Crawler $node){

            $r = $node->filter('a')->each(function (Crawler $node){
               return [$node->text(), $this->baseUrl.$node->attr('href')];
            });
            var_dump($r);


        });
    }

    public function saveAds()
    {

    }


}