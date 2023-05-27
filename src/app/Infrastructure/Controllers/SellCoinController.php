<?php

namespace App\Infrastructure\Controllers;

use App\Application\Services\SellCoinService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class SellCoinController extends BaseController
{
    private SellCoinService $sellCoinService;

    public function __construct(SellCoinService $sellCoinService)
    {
        $this->sellCoinService = $sellCoinService;
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
        return $this->sellCoinService->execute($request->input('coin_id'),$request->input('wallet_id'),$request->input('amount_usd'));
    }
}

