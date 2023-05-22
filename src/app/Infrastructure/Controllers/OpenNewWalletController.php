<?php

namespace App\Infrastructure\Controllers;

use App\Application\EarlyAdopter\OpenNewWalletService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class OpenNewWalletController extends BaseController
{

    private OpenNewWalletService $openNewWalletService;


    public function __construct(OpenNewWalletService $walletService)
    {
        $this->openNewWalletService = $walletService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        if ((implode($request->all())) != ""){
            //comprobar existencia Usuario -> para devolver un 404
            $wallet = $this->openNewWalletService->execute($request->input('user_id'));
            return response()->json(['wallet_id' => $wallet->getWalletId()], Response::HTTP_OK);
        }else{
            return response()->json([
                'error' => "user_id mandatory"
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
