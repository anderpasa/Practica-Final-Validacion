<?php

namespace App\Application\Services;

use App\Application\WalletDataSource\WalletDataSource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CriptocurriencesService
{
    private WalletDataSource $walletDataSource;

    public function __construct(WalletDataSource $walletDataSource)
    {
        $this->walletDataSource = $walletDataSource;
    }

    /**
     * @throws Exception
     */
    public function execute(string $wallet_id): JsonResponse
    {
        try {
            $wallet = $this->walletDataSource->get($wallet_id);
        }catch (Exception){
            return response()->json(['error' => "wallet_id mandatory",
            ], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            $wallet->getCoins()
        ], Response::HTTP_OK);
    }
}
