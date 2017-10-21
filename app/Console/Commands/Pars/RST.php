<?php

namespace App\Console\Commands\Pars;


use App\TParser\ParserAvailable\RSTParser;
use Illuminate\Console\Command;

class RST extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:rsm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run pars rst.ua';


    /**
     * @var RSTParser
     */
    protected $rsmParser;
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
        $rst = new RSTParser();
        $rst->getAds();

    }
}
