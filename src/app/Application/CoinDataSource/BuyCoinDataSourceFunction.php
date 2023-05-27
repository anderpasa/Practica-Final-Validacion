<?php

namespace App\Application\CoinDataSource;

use App\Application\WalletDataSource\WalletDataSource;
use App\Domain\Coin;
use App\Domain\Wallet;
use Illuminate\Cache\Events\CacheHit;
use Illuminate\Support\Facades\Cache;
use Exception;

class BuyCoinDataSourceFunction implements BuyCoinDataSource
{
    private WalletDataSource $walletRepository;
    private array $coins;

    /**
     * @throws Exception
     */
    public function buyCoin(string $coin_id,string $wallet_id,float $amount): string
    {














        /*
        if (Cache::has('wallet'.$wallet_id))
        {
            $wallet = Cache::get('wallet'.$wallet_id);
            if($wallet != null)
            {
                $coin2 = $wallet->getCoins();
                foreach ($coin2 as $k=>$coin)
                {
                    if($coin->getCoinId() == $coin_id)
                    {
                        $coin->setAmount($coin->getAmount()+$amount);
                        $esta = true;
                    }
                }
                $wallet->setCoins($coin2);
                Cache::put('wallet'.$wallet_id,$wallet);
                if(!$esta)
                {
                    $data = $data[0];
                    $name = $data->name;
                    $symbol = $data->symbol;
                    $value_usd = floatval($data->price_usd);
                    $Coin = new Coin($coin_id,$name,$symbol,$amount,$value_usd);
                    $coin2[] = $Coin;
                }
                return  "successful operation";
            }
        }
        throw new Exception();
        */
    }
}
