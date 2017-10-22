<?php

namespace App\Console\Commands\Pars;

use Illuminate\Console\Command;
use App\TParser\ParserAvailable\AutoRiaParser;

class AutoRia extends Command
{

    protected $signature = 'parse:ar';
    protected $description = 'Run pars auto.ria.com';

    protected $commands = array();
    protected $rsmParser;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try{
            $this->runParse();
        }catch (\Exception $e){
            dd($e->getLine(), $e->getMessage(), $e->getFile());
        }
    }

    protected function runParse(){
        $rst = new AutoRiaParser();
        $rst->getAds();

    }
}
