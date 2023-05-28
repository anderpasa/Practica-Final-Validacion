<?php

namespace App\Application\Services;

use App\Application\CoinDataSource\CryptoCoinDataSource;
use App\Application\WalletDataSource\WalletDataSource;
use App\Domain\Coin;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CriptoBalanceService
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
    public function execute(string $wallet_id): JsonResponse
    {
        $balance = 0;
        try {
            $wallet = $this->walletDataSource->get($wallet_id);
        }catch (Exception){
            return response()->json(['error' => "wallet_id mandatory",
            ], Response::HTTP_BAD_REQUEST);
        }
        $coins = $wallet->getCoins();
        $invertido = 0;
        $valorActual =0;

        foreach ($coins as $coin) {
            $valorActual += $this->cryptoCoinDataSource->findByCoinId($coin->getCoinId())->getValueUsd()*$coin->getAmount();
            $invertido += $coin->getValueUsd();
        }

        $balance=$valorActual-$invertido;
        return response()->json(['balance_usd'=>$balance,
        ], Response::HTTP_OK);
    }
}
