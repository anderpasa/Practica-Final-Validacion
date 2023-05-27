<?php

namespace App\Application\Services;

use App\Application\CoinDataSource\CryptoCoinDataSource;
use App\Application\WalletDataSource\WalletDataSource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class BuyCoinService
{
    private WalletDataSource $walletDataSource;
    private CryptoCoinDataSource $cryptoCoinDataSource;

    public function __construct(WalletDataSource $walletDataSource, CryptoCoinDataSource $cryptoCoinDataSource)
    {
        $this->walletDataSource = $walletDataSource;
        $this->cryptoCoinDataSource = $cryptoCoinDataSource;
    }

    /**
     * @throws Exception
     */
    public function execute(string $coin_id, string $wallet_id, float $amount_usd): JsonResponse
    {
        try {
            $coin = $this->cryptoCoinDataSource->findByCoinId($coin_id);
        }catch (Exception){
            return response()->json([
                'error' => "A coin with the specified ID was not found"
            ], Response::HTTP_NOT_FOUND);
        }

        try {
            $wallet = $this->walletDataSource->get($wallet_id);
        }catch (Exception){
            return response()->json([
            ], Response::HTTP_BAD_REQUEST);
        }

        $this->walletDataSource->insertCoin($wallet, $coin, $amount_usd);
        return response()->json([
        ], Response::HTTP_OK);
    }
}
