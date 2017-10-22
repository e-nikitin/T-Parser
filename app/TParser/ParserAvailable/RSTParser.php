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
        //$links = collect(['http://rst.ua/oldcars/audi/a4/audi_a4_7501789.html']);
        //dd($links);

        // Ссылки по которым можно получить нужную информациюю - готовы.
        // Формирую колекцию обьявлений со страниц
        $ads = collect();
        $links->each(function($link) use ($ads){
            $ads->push(head($this->initCrawler($link)->filter('#rst-page-oldcars-item')->each(function (Crawler $node){
                // Вытягиваю фото
                $photo = head($node->filter('#rst-page-oldcars-item-photos-block')->each(function (Crawler $node){
                    $r = $node->filter('a')->reduce(function (Crawler $node, $i){
                        return $i == 1;
                    })->each(function (Crawler $node){
                        return $node->attr('href');
                    });

                    return ['photo' => head($r)];
                }));

                // Вытягиваю основную информацию об авто
                $prop = head($node->filter('.rst-page-oldcars-item-option-block.rst-uix-clear > table')->each(function (Crawler $node){
                    $price = head($node->filter('tr')->eq(0)->filter('td')->eq(1)->filter('span > span')->each(function (Crawler $node){
                        return (float) str_replace(['$','\'','/',' '],'',$node->text());
                    }));
                    $iss_year = head($node->filter('tr')->eq(1)->filter('td')->eq(1)->filter('a')->each(function (Crawler $node){
                        return (int)$node->text();
                    }));
                    $tkm = head($node->filter('tr')->eq(1)->filter('td')->eq(1)->filter('span')->each(function (Crawler $node){
                        return ((int)str_replace(['(',')','-','пробег', ' '], '', $node->text())) / 1000;
                    }));
                    $engine = head($node->filter('tr')->eq(2)->filter('td')->eq(1)->each(function (Crawler $node){
                        return $node->text();
                    }));
                    $kpp = head($node->filter('tr')->eq(3)->filter('td')->eq(1)->each(function (Crawler $node){
                        return $node->text();
                    }));
                    $carcase_type = head($node->filter('tr')->eq(4)->filter('td')->eq(1)->each(function (Crawler $node){
                        return $node->text();
                    }));
                    $region = head($node->filter('tr')->eq(5)->filter('td')->eq(1)->each(function (Crawler $node){
                        return $node->text();
                    }));
                    $upload_date = head($node->filter('tr')->eq(7)->filter('td')->eq(1)->each(function (Crawler $node){
                        return $node->text();
                    }));
                    return compact('price', 'iss_year', 'tkm', 'engine', 'kpp', 'carcase_type', 'region', 'upload_date');
                }));
                if (empty($prop)){
                    $prop = head($node->filter('.rst-page-oldcars-item-option-block.rst-uix-clear > ul')->each(function (Crawler $node){
                        $price = head($node->filter('li')->eq(0)->filter('span')->eq(1)->filter('span > span')->each(function (Crawler $node){
                            return (float) str_replace(['$','\'','/',' '],'',$node->text());
                        }));
                        $iss_year = head($node->filter('li')->eq(1)->filter('span')->eq(1)->filter('a')->each(function (Crawler $node){
                            return (int)$node->text();
                        }));
                        $tkm = head($node->filter('li')->eq(1)->filter('span')->eq(1)->filter('span')->each(function (Crawler $node){
                            return ((int)str_replace(['(',')','-','пробег', ' '], '', $node->text())) / 1000;
                        }));
                        $engine = head($node->filter('li')->eq(2)->filter('span')->eq(1)->each(function (Crawler $node){
                            return $node->text();
                        }));
                        $kpp = head($node->filter('li')->eq(3)->filter('span')->eq(1)->each(function (Crawler $node){
                            return $node->text();
                        }));
                        $carcase_type = head($node->filter('li')->eq(4)->filter('span')->eq(1)->each(function (Crawler $node){
                            return $node->text();
                        }));
                        $region = head($node->filter('li')->eq(5)->filter('span')->eq(1)->each(function (Crawler $node){
                            return $node->text();
                        }));
                        $upload_date = head($node->filter('li')->eq(7)->filter('span')->eq(1)->each(function (Crawler $node){
                            return $node->text();
                        }));
                        return compact('price', 'iss_year', 'tkm', 'engine', 'kpp', 'carcase_type', 'region', 'upload_date');
                    }));
                }
                // Вытягиваю контактные данные
                $contactInfo = head($node->filter('.rst-page-oldcars-item-option-block-container')->eq(1)->each(function (Crawler $node){
                    $name = head($node->filter('b')->each(function (Crawler $node){
                        return $node->text();
                    }));
                    if (empty($name)){
                        $name = head($node->filter('strong')->each(function (Crawler $node){
                            return $node->text();
                        }));
                    }
                    $phons = $node->filter('table > tr')->each(function (Crawler $node){
                        return str_replace(['тел.:',' '],'',$node->text());
                    });
                    if (empty($phons)){
                        $phons = $node->filter('ul > li')->each(function (Crawler $node){
                            return str_replace(['тел.:',' '],'',$node->text());
                        });
                    }
                    if (empty($phons)){
                        $phons = $node->filter('span')->each(function (Crawler $node){
                            return str_replace(['тел.:',' '],'',$node->text());
                        });
                    }
                    if (empty($phons)){
                        $phons = $node->each(function (Crawler $node){
                            return preg_replace('/[^0-9,]/', '', $node->text());;
                        });
                    }
                    $phons = collect($phons)->filter(function ($phone){
                        return !empty($phone);
                    })->unique()->values()->all();
                    return compact('name', 'phons');
                }));

                return array_merge($contactInfo, $prop, $photo);
            })));
        });

        return $ads;
    }

    protected function handleLinks(){

    }

    public function saveAds()
    {

    }
/*
$price = head($node->filter('tr > td > span.rst-uix-price-param > span.rst-uix-grey')->each(function (Crawler $node){
                        return (float) str_replace(['$','\'','/',' '],'',$node->text());
                    }));
                    $iss_date = head($node->filter('tr > td > a')->each(function (Crawler $node){
                        return (int)$node->text();
                    }));
                    $t_km = head($node->filter('tr > td > span')->each(function (Crawler $node){
                        dd($node->text());
                    }));


* */

}