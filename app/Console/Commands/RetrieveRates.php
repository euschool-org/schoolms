<?php

namespace App\Console\Commands;

use App\Models\Currency;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class RetrieveRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:retrieve-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieve NBG currency rates';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $euro = Currency::find(1);
        $usd = Currency::find(2);
        $response = Http::get('https://nbg.gov.ge/gw/api/ct/monetarypolicy/currencies/en/json/?currencies=EUR');
        $euro->rate_to_gel = $response->json(0)['currencies'][0]['rate'];
        $euro->saveOrFail();
        $response = Http::get('https://nbg.gov.ge/gw/api/ct/monetarypolicy/currencies/en/json/?currencies=USD');
        $usd->rate_to_gel = $response->json(0)['currencies'][0]['rate'];
        $usd->saveOrFail();
    }
}
