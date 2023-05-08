<?php

namespace App\Domain;

Interface CoinRepository
{
    public function buyCoin();

    public function sellCoin();
}
