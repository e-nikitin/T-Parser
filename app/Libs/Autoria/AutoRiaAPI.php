<?php

namespace App\Libs\Autoria;

use Illuminate\Database\Eloquent\Model;

class AutoRiaAPI extends Model
{
    protected $Api_url;
    protected $API_KEY;

    public function __construct()
    {
        $this->API_KEY = env('AUTO_RIA_KEY');
    }

    //Получить авто по параметрам, если пуст то все авто
    public function getCarIdsByParams($params='') {
       $url =  $this->Api_url = 'https://developers.ria.com/auto/search?api_key='.$this->API_KEY.'&countpage=100'; //.'&'
        if($params) {
            $urlParams = '';
            foreach ($params as $key =>$value ) {
                $url = $url."&$key=$value";
            }
            //$url = $url.$urlParams;
        }
        return $this->APIquery($url);
    }

    //Получить инфо об авто по Id
    public function  getCarInfoById ($id) {
        $url = "https://developers.ria.com/auto/info?api_key=$this->API_KEY&auto_id=$id";
        return $this->APIquery($url);
    }

    //Получить все марки с их id
    public function getAllMarksWithIds($categoryid) {
        $url = "https://developers.ria.com/auto/categories/$categoryid/marks?api_key=$this->API_KEY";
        return $this->APIquery($url);
    }

    //Получить все модели с их id
    public function getModelsByMarkId($categoryid,$markid) {
        $url = "https://developers.ria.com/auto/categories/$categoryid/marks/$markid/models/_group?api_key=$this->API_KEY";
        return $this->APIquery($url);
    }











    //Отправка запроса
    private function APIquery($url) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url
        ));
        $resp = curl_exec($curl);
        curl_close($curl);
        $result =  json_decode($resp,true);
        return $result;
    }



}
