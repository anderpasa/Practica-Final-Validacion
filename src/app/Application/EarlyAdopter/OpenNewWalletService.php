<?php

namespace App\Application\EarlyAdopter;

use App\Application\WalletDataSource\WalletDataSource;
use App\Domain\Wallet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
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
        $wallet_id = $user_id;          //Como se nos ha dicho que no nos compliquemos y que cada usuario tiene una y solo una cartera, no tendría que haber problema
        try{
            return $this->walletRepository->get($wallet_id);
        }catch(Exception){
            return $this->walletRepository->add($wallet_id);
        }
    }
}
