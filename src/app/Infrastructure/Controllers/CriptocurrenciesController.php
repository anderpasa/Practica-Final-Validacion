<?php

namespace App\Infrastructure\Controllers;


use App\Application\Services\CriptocurriencesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class CriptocurrenciesController extends BaseController
{
    private CriptocurriencesService $criptocurriencesService;

    public function __construct(CriptocurriencesService $currenciesService)
    {
        $this->criptocurriencesService = $currenciesService;
    }

    /**
     * @throws \Exception
     */
    public function __invoke($wallet_id): JsonResponse
    {
        if(is_null($wallet_id))
        {
            return response()->json(
                ['error' => "wallet_id mandatory"], Response::HTTP_BAD_REQUEST);
        }
        return $this->criptocurriencesService->execute($wallet_id);
    }
}

