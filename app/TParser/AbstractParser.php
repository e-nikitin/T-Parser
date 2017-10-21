<?php
namespace App\TParser;
use Illuminate\Support\Collection;
use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractParser
{

    /**
     *
     * Возвращает Collection
     * @return Collection
     */
    abstract public function getAds();

    /**
     *
     * @return bool
     */
    abstract public function saveAds();

    /**
     * @param $url
     * @return Crawler
     */
    protected function initCrawler($url){
        return new Crawler(file_get_contents($url));
    }

}