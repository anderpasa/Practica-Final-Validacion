<?php

namespace App\Infrastructure\Controllers;

use App\Application\CoinService\BuyCoinService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class BuyCoinController extends BaseController
{
    private BuyCoinService $buyCoinService;

    public function __construct(BuyCoinService $buyCoinService)
    {
        $this->buyCoinService = $buyCoinService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        if(is_null($request->input('coin_id')))
        {
            return response()->json([
                'error' => "coin_id mandatory"
            ], Response::HTTP_BAD_REQUEST);
        }
        elseif( is_null($request->input('wallet_id')))
        {
            return response()->json([
                'error' => "wallet_id mandatory"
            ], Response::HTTP_BAD_REQUEST);
        }
        elseif( is_null($request->input('amount_usd')))
        {
            return response()->json([
                'error' => "amount_usd mandatory"
            ], Response::HTTP_BAD_REQUEST);
        }
        return $this->buyCoinService->execute($request->input('coin_id'),$request->input('wallet_id'),$request->input('amount_usd'));
    }
}

