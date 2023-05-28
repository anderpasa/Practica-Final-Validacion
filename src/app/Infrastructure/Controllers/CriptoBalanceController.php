<?php

namespace App\Infrastructure\Controllers;

use App\Application\Services\CriptoBalanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class CriptoBalanceController extends BaseController
{

    private CriptoBalanceService $criptoBalanceService;


    public function __construct(CriptoBalanceService $criptoBalanceService)
    {
        $this->criptoBalanceService = $criptoBalanceService;
    }

    public function __invoke(String $wallet_id): JsonResponse
    {
        if(is_null($wallet_id))
        {
            return response()->json(
                ['error' => "wallet_id mandatory"], Response::HTTP_BAD_REQUEST);
        }
        return $this->criptoBalanceService->execute($wallet_id);
    }
}
