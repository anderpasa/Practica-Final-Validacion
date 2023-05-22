<?php

namespace App\Application\WalletDataSource;

use App\Domain\Wallet;
use Illuminate\Support\Facades\Cache;
use Mockery\Exception;

class WalletDataSourceFunctions implements WalletDataSource
{
    public function add(String $user_id) : Wallet
    {
        $wallet = new Wallet($user_id,[]);
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


}
