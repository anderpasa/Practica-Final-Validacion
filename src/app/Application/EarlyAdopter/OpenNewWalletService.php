<?php

namespace App\Application\EarlyAdopter;

use App\Application\WalletDataSource\WalletDataSource;
use App\Domain\Wallet;
use Exception;

class OpenNewWalletService
{
    private WalletDataSource $walletRepository;

    public function __construct(WalletDataSource $walletDataSource)
    {
        $this->walletRepository = $walletDataSource;
    }

    /**
     * @throws Exception
     */
    public function execute(String $user_id): Wallet
    {
        $wallet_id = $user_id;
        try{
            return $this->walletRepository->get($wallet_id);
        }catch(Exception){
            return $this->walletRepository->add($wallet_id);
        }
    }
}
