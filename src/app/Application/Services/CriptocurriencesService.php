<?php

namespace App\Application\Services;

use App\Application\WalletDataSource\WalletDataSource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use function PHPUnit\Framework\isEmpty;

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
        } catch (Exception $e) {
            return response()->json(['error' => "Error fetching wallet: " . $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        if ($wallet === null) {
            return response()->json(['error' => "Wallet not found"], Response::HTTP_NOT_FOUND);
        }


        //var_dump($wallet->getCoins());
        return response()->json(['coins' => $wallet->getCoins()], Response::HTTP_OK);

    }


}
