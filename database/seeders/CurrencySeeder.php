<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Services\BlockchainInfoService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws GuzzleException
     */
    public function run(): void
    {
        $blockChain = new BlockchainInfoService();
        $currenciesResponse = $blockChain->getCurrencies();
        $currencies = json_decode($currenciesResponse, true);

        foreach ($currencies as $currencyData) {
            $currency = new Currency();

            $currency->name = $currencyData['symbol'];
            $currency->exchange_rate = $currencyData['last'];

            $currency->save();
        }
    }
}
