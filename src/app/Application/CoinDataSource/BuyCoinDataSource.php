<?php

namespace App\Application\CoinDataSource;

Interface BuyCoinDataSource
{
    public function buyCoin(string $coin_id,string $wallet_id,float $amount);
}
