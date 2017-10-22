<?php
namespace App\TParser\ParserAvailable;


use App\TParser\AbstractParser;
use Symfony\Component\DomCrawler\Crawler;

class AutoRiaParser extends AbstractParser
{
    protected $url = 'https://auto.ria.com/search/#page=0&countpage=10&power_name=1&marka_id%5B0%5D=0&model_id%5B0%5D=0&s_yers%5B0%5D=0&po_yers%5B0%5D=0&currency=1&custom=3&engineVolumeFrom=&engineVolumeTo=';
    protected $baseUrl = 'https://auto.ria.com';

    public function getAds(){
        $ads = collect();
       $crawler = $this->initCrawler($this->url);

       /* $crawler->filter('section.ticket-item ')->each(function (Crawler $node){

            var_dump($node->attr('class'));
           /* $r = $node->filter('a')->each(function (Crawler $node){
                return [$node->text(), $this->baseUrl.$node->attr('href')];
            });*/


      //  });


        $a = file_get_contents('https://auto.ria.com/newauto_blocks/informer?limit=10&lang_id=2&page=1');
dd( $a);

    }

    public function saveAds()
    {

    }


}