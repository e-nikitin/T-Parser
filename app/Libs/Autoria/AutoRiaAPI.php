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
        $this->Api_url = 'https://developers.ria.com/auto/search?api_key='.$this->API_KEY ; //.'&'
    }

    public function index() {

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $this->Api_url
        ));
        $resp = curl_exec($curl);
        curl_close($curl);
      dd(json_decode($resp));


    }
}
