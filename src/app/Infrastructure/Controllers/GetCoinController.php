<?php

namespace App\Infrastructure\Controllers;

use App\Application\Services\CoinService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Exception;

class GetCoinController extends BaseController
{
    private $CoinService;

    /**
     * UserController constructor.
     */
    public function __construct(CoinService $CoinService)
    {
        $this->CoinService = $CoinService;
    }

    public function __invoke(int $id): JsonResponse
    {
        try {
            $CoinService = $this->CoinService->execute($id);
        } catch (Exception $exception) {
            if ($exception->getMessage() == "A coin with the specified ID was not found") {
                return response()->json([
                    'error' => $exception->getMessage()
                ], Response::HTTP_NOT_FOUND);
            }else{
                return response()->json([
                    'error' => 'DataSource Unavailible'
                ], Response::HTTP_SERVICE_UNAVAILABLE);
            }
        }

        return response()->json([
            $CoinService
        ], Response::HTTP_OK);
    }
}
