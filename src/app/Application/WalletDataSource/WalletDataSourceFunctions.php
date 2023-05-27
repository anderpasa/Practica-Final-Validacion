<?php

namespace App\Application\WalletDataSource;

use App\Domain\Coin;
use App\Domain\Wallet;
use Illuminate\Support\Facades\Cache;
use Mockery\Exception;

class WalletDataSourceFunctions implements WalletDataSource
{
    public function add(String $user_id) : Wallet
    {
        $wallet = new Wallet($user_id,[]);
        $wallet->setIdUsuario($user_id);
        Cache::put('wallet'.$user_id,$wallet);
        return $wallet;
    }

    public function get(String $wallet_id): Wallet
    {
        if(Cache::has('wallet'.$wallet_id)) {
            return Cache::get('wallet'.$wallet_id);
        }
        throw new Exception();
    }

    public function insertCoin(Wallet $wallet, Coin $coin, float $amount_usd):void
    {
        $coin_id = $coin->getCoinId();
        $price = $coin->getValueUsd();
        $wallet_id = $wallet->getWalletId();
        $amount_coins = $amount_usd/$price;

        foreach ($wallet['coins'] as $coin2){
            if(strcmp($coin2['coin_id'], $coin_id) === 0){
                $wallet['coins']['amount'] += $amount_coins;
                Cache::put('wallet'.$wallet_id,$wallet);
            }
        }
    }

    public function sellCoin(Wallet $wallet, Coin $coin, float $amount_usd):void
    {
        $coin_id = $coin->getCoinId();
        $price = $coin->getValueUsd();
        $wallet_id = $wallet->getWalletId();
        $amount_coins = $amount_usd/$price;

        foreach ($wallet['coins'] as $coin2){
            if(strcmp($coin2['coin_id'], $coin_id) === 0){
                $wallet['coins']['amount'] -= $amount_coins;
                Cache::put('wallet'.$wallet_id,$wallet);
            }
        }
    }
}
