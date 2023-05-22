<?php

namespace App\Application\WalletDataSource;

use App\Domain\Wallet;
use Illuminate\Http\JsonResponse;

Interface WalletDataSource
{
    public function add(String $user_id) : Wallet;
    public function get(String $wallet_id) : Wallet;
}
