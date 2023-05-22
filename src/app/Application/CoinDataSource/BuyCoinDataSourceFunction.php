<?php

namespace App\Application\CoinDataSource;

use App\Domain\Coin;
use Illuminate\Support\Facades\Cache;
use Exception;

class BuyCoinDataSourceFunction implements BuyCoinDataSource
{
    /**
     * @throws Exception
     */
    public function buyCoin(string $coin_id,string $wallet_id,float $amount): string
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

        /*
        //Propuestas para esta función y en la de sellCoin:
        //Hacer uso de CryptoCoinDataSource.php y cambiar lo de arriba por un:

        $coin = findByCoinId($coin_id);

        //Y cambiar la función de Wallet de "setCoins" (l. 48) para hacer un "addCoin". A partir de ahí, plantearnos si
        //es posible y necesario hacer un "addCoins" por si el usuario quiere comprar más de una moneda
        */

        $esta = false;
        $wallet = Cache::get($wallet_id);
        if($wallet != null) {
            $coin2 = $wallet->getCoins();
            foreach ($coin2 as $k=>$coin){
                if($coin->getCoinId() == $coin_id){
                    $coin->setAmount($coin->getAmount()+$amount);
                    $esta = true;
                }
            }
            $wallet->setCoins($coin2);
            Cache::put('wallet'.$wallet_id,$wallet);
            if(!$esta) {
                $data = $data[0];
                $name = $data->name;
                $symbol = $data->symbol;
                $value_usd = floatval($data->price_usd);
                $Coin = new Coin($coin_id,$name,$symbol,$amount,$value_usd);
                $coin2[] = $Coin;
            }
            return  "successful operation";
        }
        return "";  //error wallet not exists
    }
}
