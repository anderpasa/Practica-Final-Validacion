<?php

namespace Tests\app\Infrastructure\Controller;
use App\Domain\Coin;
use App\Domain\Wallet;
use Mockery;
use App\Application\WalletDataSource\WalletDataSource;
use Tests\TestCase;

class CriptocurrenciesControllerTest extends TestCase
{
    private WalletDataSource $walletDataSource;

    protected function setUp(): void
    {
        parent::setUp();

        $this->walletDataSource = Mockery::mock(WalletDataSource::class);
        $this->app->bind(WalletDataSource::class, fn () => $this->walletDataSource);
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

        $response = $this->get('/api/wallet/-1');

        $response->assertExactJson(['error' => 'wallet_id mandatory']);
    }

    /**
     * @test
     */
    public function walletExiste()
    {
        $walletId = 0;
        $walletCoins = [
            (new Coin('90', 'Bitcoin', 'BTC', 4, 26829.64))->getJsonData(),
            (new Coin('80', 'Ethereum', 'ETH', 10, 1830))->getJsonData(),
            (new Coin('518', 'Tether', 'USDT', 2, 1.00))->getJsonData(),
            (new Coin('2710', 'Binance Coin', 'BNB', 4, 30705))->getJsonData(),
        ];
        $wallet = new Wallet($walletId, $walletCoins);


        //$wallet = new Wallet(1, []);
        $this->walletDataSource
            ->expects('get')
            ->with(1)
            ->andReturn($wallet);

        $response = $this->get('/api/wallet/1');

        $response->assertExactJson([$walletCoins]);
    }


}

