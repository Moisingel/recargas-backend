<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();
        try {
            $banks = [
                ['name' => 'Interbank'],
                ['name' => 'BCP'],
                ['name' => 'BBVA'],
                ['name' => 'Scotiabank'],
                ['name' => 'Banbif'],
                ['name' => 'MiBanco'],
                ['name' => 'Banco de la Nación'],
                ['name' => 'Banco Pichincha']
            ];
            foreach ($banks as $bank) {
                \App\Models\Bank::create($bank);
            }
            $channels = [
                ['name' => 'Whatsapp'],
                ['name' => 'Telegram']
            ];
            foreach ($channels as $channel) {
                \App\Models\Channel::create($channel);
            }
            $countries = [
                ['name' => 'Perú'],
                ['name' => 'EEUU']
            ];
            foreach ($countries as $country) {
                \App\Models\Country::create($country);
            }
            $currencies = [
                ['name' => 'Soles', 'country_id' => 1, 'symbol' => 'S/'],
                ['name' => 'Dolares', 'country_id' => 2, 'symbol' => '$'],
            ];
            foreach ($currencies as $currency) {
                \App\Models\Currency::create($currency);
            }
            $exchanges = [
                ['from_currency_id' => 1, 'to_currency_id' => 2, 'rate' => 0.25],
                ['from_currency_id' => 2, 'to_currency_id' => 1, 'rate' => 4],
            ];
            foreach ($exchanges as $exchange) {
                \App\Models\CurrencyExchange::create($exchange);
            }
            $clients = [
                ['name' => 'Juan Perez', 'player_id' => '123456789'],
                ['name' => 'Pedro Garcia', 'player_id' => '987654321'],
                ['name' => 'Luis Perez', 'player_id' => '987654322'],
            ];
            foreach ($clients as $client) {
                \App\Models\Client::create($client);
            }
            $wallets = [
                ['client_id' => 1, 'currency_id' => 1, 'amount' => 0.0, 'last_recharge' => '2023-04-24'],
                ['client_id' => 2, 'currency_id' => 1, 'amount' => 0.0, 'last_recharge' => '2023-04-24'],
                ['client_id' => 3, 'currency_id' => 1, 'amount' => 0.0, 'last_recharge' => '2023-04-24'],
            ];
            foreach ($wallets as $wallet) {
                \App\Models\Wallet::create($wallet);
            }
            $promoters = [
                ['name' => 'Carlos Magno'],
                ['name' => 'Julio Cesar'],
            ];
            foreach ($promoters as $promoter) {
                \App\Models\Promoter::create($promoter);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            error_log($th->getMessage());
        }
    }
}
