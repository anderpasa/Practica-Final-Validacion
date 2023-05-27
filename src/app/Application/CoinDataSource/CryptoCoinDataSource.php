<?php

namespace App\Application\CoinDataSource;

use App\Domain\Coin;
use Exception;

class CryptoCoinDataSource implements CoinDataSource
{
    /**
     * @throws Exception
     */
    public function findByCoinId(string $coin_id): Coin
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.coinlore.net/api/ticker/?id=' . $coin_id,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_RETURNTRANSFER => true,
        ));
        $response = curl_exec($curl);
        //print($response);
        curl_close($curl);

        if($response === "[]"){
            throw new Exception();
        }
        $data = json_decode($response);
        $data = $data[0];
        $name = $data->name;
        $symbol = $data->symbol;
        $amount = 0;
        $value_usd = floatval($data->price_usd);

        return new Coin($coin_id,$name,$symbol,$amount,$value_usd);
    }
}
