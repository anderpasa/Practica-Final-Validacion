<?php

namespace App\Application\CoinDataSource;

Interface CoinDataSource
{
    public function findByCoinId(string $coin_id);
}
