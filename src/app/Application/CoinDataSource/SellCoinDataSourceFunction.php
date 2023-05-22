<?php

namespace App\Application\CoinDataSource;

use Illuminate\Support\Facades\Cache;
use Exception;

class SellCoinDataSourceFunction implements SellCoinDataSource
{
    /**
     * @throws Exception
     */
    public function sellCoin(string $coin_id, string $wallet_id, float $amount_usd)
    {
        $url = 'https://api.coinlore.net/api/ticker/?id=' . $coin_id;

        $ch = curl_init( $url );
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HEADER,0);

        $data = json_decode(curl_exec($ch));
        curl_close($ch);
        if($data == null){
            throw new Exception("A coin with the specified ID was not found.");
        }
        $esta = false;
        $wallet = Cache::get($wallet_id);
        if($wallet != null) {
            $coins = $wallet->getCoins();
            //optimización: $coins.contains($coin_id) para probar si devuelve verdadero si existe una coin con ese id
            foreach ($coins as $k=>$coin){
                if($coin->getCoinId() == $coin_id){
                    $coin->setAmount($coin->getAmount()-$amount_usd);
                    if($coin->getAmount() < 0){
                        unset($coins[$k]);
                    }
                    $esta = true;
                }
            }

            $wallet->setCoins($coins);
            Cache::put($wallet_id, $wallet);
        }
        if(!$esta) {
            throw new Exception("A coin with the specified ID was not found.");
        }
        return  "successful operation";
    }
}
