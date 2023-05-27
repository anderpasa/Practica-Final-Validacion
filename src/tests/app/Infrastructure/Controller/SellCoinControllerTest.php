<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\CoinDataSource\CoinDataSource;
use App\Application\WalletDataSource\WalletDataSource;
use App\Domain\Coin;
use App\Domain\Wallet;
use Tests\TestCase;
use Exception;
use Illuminate\Http\Response;
use Mockery;

define("token", array(
    'Content-Type: application/json'
));
class SellCoinControllerTest extends TestCase
{
    private WalletDataSource $WalletDataSource;
    private CoinDataSource $CoinDataSource;

    /**
     * @setUp
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->WalletDataSource = Mockery::mock(WalletDataSource::class);
        $this->app->bind(WalletDataSource::class, fn() => $this->WalletDataSource);
        $this->CoinDataSource = Mockery::mock(CoinDataSource::class);
        $this->app->bind(CoinDataSource::class, fn() => $this->CoinDataSource);
    }

    /**
     * @test
     */
    public function badRequests()
    {
        $coin_id = '1';
        $wallet_id = "1";
        $amount_usd = 1;

        $response1 = $this->post('api/coin/sell',["wallet_id" => "$wallet_id", "amount_usd" => $amount_usd]);
        $response2 = $this->post('api/coin/sell',["coin_id" => "$coin_id", "amount_usd" => $amount_usd]);
        $response3 = $this->post('api/coin/sell',["coin_id" => "$coin_id", "wallet_id" => "$wallet_id"]);

        $response1->assertStatus(Response::HTTP_BAD_REQUEST);
        $response2->assertStatus(Response::HTTP_BAD_REQUEST);
        $response3->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     * @test
     */
    public function coinWithGivenIdDoesNotExist()
    {
        $coin_id = "99999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999";
        $wallet_id = "1";
        $amount_usd = 1;
        $this->CoinDataSource
            ->expects('findByCoinId')
            ->with($coin_id)
            ->times(0)
            ->andThrow(new Exception('A coin with the specified ID was not found'));

        $response = $this->post('api/coin/sell', ["coin_id" => "$coin_id", "wallet_id" => "$wallet_id", "amount_usd" => $amount_usd]);

        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertExactJson(['error' => 'A coin with the specified ID was not found']);
    }

    /**
     * @test
     */
    public function addNewCoinToWallet()
    {
        $coin_id = '10';
        $wallet_id = "1";
        $amount_usd = 1;
        $this->CoinDataSource
            ->expects('findByCoinId')
            ->with($coin_id)
            ->times(0)
            ->andReturn(new Coin($coin_id, "BlackCoin", "BLK", 0, 0.017389));
        $this->WalletDataSource
            ->expects("get")
            ->with($wallet_id)
            ->andReturn(new Wallet(1, []));
        $this->WalletDataSource
            ->expects("sellCoin");

        $response = $this->post('api/coin/sell', ["coin_id" => "$coin_id", "wallet_id" => "$wallet_id", "amount_usd" => $amount_usd]);

        $response->assertStatus(Response::HTTP_OK);
    }
}
