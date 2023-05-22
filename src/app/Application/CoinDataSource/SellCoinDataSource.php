<?php

namespace App\Application\CoinDataSource;

interface SellCoinDataSource
{
    public function sellCoin(string $coin_id, string $wallet_id, float $amount_usd);
}
