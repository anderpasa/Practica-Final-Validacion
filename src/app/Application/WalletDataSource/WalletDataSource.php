<?php

namespace App\Application\WalletDataSource;

use App\Domain\Coin;
use App\Domain\Wallet;

Interface WalletDataSource
{
    public function add(String $user_id) : Wallet;
    public function get(String $wallet_id) : Wallet;
    public function insertCoin(Wallet $wallet, Coin $coin) : void;
}
