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
        $wallet = new Wallet(1, []);
        $this->walletDataSource
            ->expects('get')
            ->with(1)
            ->andReturn($wallet);

        $response = $this->get('/api/wallet/1');

        $response->assertExactJson([[]]);
    }


}

