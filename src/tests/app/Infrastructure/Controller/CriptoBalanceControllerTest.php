<?php

namespace Tests\app\Infrastructure\Controller;
use App\Application\CoinDataSource\CoinDataSource;
use App\Application\CoinDataSource\CryptoCoinDataSource;
use App\Domain\Coin;
use App\Domain\Wallet;
use Mockery;
use App\Application\WalletDataSource\WalletDataSource;
use Tests\TestCase;

class CriptoBalanceControllerTest extends TestCase
{
    private WalletDataSource $walletDataSource;
    private CryptoCoinDataSource $coinDataSource;

    protected function setUp(): void
    {
        parent::setUp();

        $this->walletDataSource = Mockery::mock(WalletDataSource::class);
        $this->app->bind(WalletDataSource::class, fn () => $this->walletDataSource);

        $this->coinDataSource = Mockery::mock(CryptoCoinDataSource::class);
        $this->app->bind(CryptoCoinDataSource::class, fn () => $this->coinDataSource);
    }

    /**
     * @test
     */
    public function walletNoExiste()
    {
        $this->walletDataSource
            ->expects("get")
            ->with(null)
            ->times(0)
            ->andReturn(Exception::class);

        $response = $this->get('/api/wallet/-1/balance');

        $response->assertExactJson(['error' => 'wallet_id mandatory']);
    }

    /**
     * @test
     */
    public function walletVacia()
    {
        $wallet = new Wallet(1, []);
        $this->walletDataSource
            ->expects('get')
            ->with(1)
            ->andReturn($wallet);

        $response = $this->get('/api/wallet/1/balance');

        $response->assertExactJson(["balance_usd"=> 0]);
    }

    /**
     * @test
     */
    public function balancePositivo()
    {
        $coin = new Coin(1, "BlackCoin", "BLK", 1, 15);
        $coin2 = new Coin(1, "BlackCoin", "BLK", 1, 20);
        $wallet = new Wallet(1, [$coin]);
        $this->walletDataSource
            ->expects('get')
            ->with(1)
            ->andReturn($wallet);
        $this->coinDataSource
            ->expects('findByCoinId')
            ->with('1')
            ->andReturn($coin2);

        $response = $this->get('/api/wallet/1/balance');

        $response->assertExactJson(["balance_usd"=> 5]);
    }

    /**
     * @test
     */
    public function balanceNegativo2monedas()
    {
        $coin = new Coin(1, "BlackCoin", "BLK", 1, 15);
        $coin2 = new Coin(1, "BlackCoin", "BLK", 1, 20);
        $wallet = new Wallet(1, [$coin2, $coin2]);
        $this->walletDataSource
            ->expects('get')
            ->with(1)
            ->andReturn($wallet);
        $this->coinDataSource
            ->expects('findByCoinId')
            ->with('1')
            ->times(2)
            ->andReturn($coin);

        $response = $this->get('/api/wallet/1/balance');

        $response->assertExactJson(["balance_usd"=> -10]);
    }
}
