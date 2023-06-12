<?php
namespace Tests\Unit;

use App\Application\Services\SellCoinService;
use App\Application\CoinDataSource\CryptoCoinDataSource;
use App\Application\WalletDataSource\WalletDataSource;
use App\Domain\Coin;
use App\Domain\Wallet;
use Exception;
use Illuminate\Http\Response;
use Mockery;
use Tests\TestCase;

class SellCoinServiceTest extends TestCase
{
    private $sellCoinService;
    private $walletDataSourceMock;
    private $cryptoCoinDataSourceMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->walletDataSourceMock = Mockery::mock(WalletDataSource::class);
        $this->cryptoCoinDataSourceMock = Mockery::mock(CryptoCoinDataSource::class);
        $this->sellCoinService = new SellCoinService($this->walletDataSourceMock, $this->cryptoCoinDataSourceMock);
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testExecute(): void
    {
        $coin_id = '90';
        $wallet_id = '1';
        $amount_usd = 1000.00;

        $coin = new Coin($coin_id, 'Bitcoin', 'BTC', 0, 50000.00);
        $wallet = new Wallet($wallet_id, []);

        $this->cryptoCoinDataSourceMock->shouldReceive('findByCoinId')
            ->once()
            ->with($coin_id)
            ->andReturn($coin);

        $this->walletDataSourceMock->shouldReceive('get')
            ->once()
            ->with($wallet_id)
            ->andReturn($wallet);

        $this->walletDataSourceMock->shouldReceive('sellCoin')
            ->once()
            ->with($wallet, $coin, $amount_usd);

        $response = $this->sellCoinService->execute($coin_id, $wallet_id, $amount_usd);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testExecuteWithInvalidCoinId(): void
    {
        $coin_id = 'invalid_coin_id';
        $wallet_id = '1';
        $amount_usd = 1000.00;

        $this->cryptoCoinDataSourceMock->shouldReceive('findByCoinId')
            ->once()
            ->with($coin_id)
            ->andThrow(Exception::class);

        $response = $this->sellCoinService->execute($coin_id, $wallet_id, $amount_usd);

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testExecuteWithInvalidWalletId(): void
    {
        $coin_id = '90';
        $wallet_id = 'invalid_wallet_id';
        $amount_usd = 1000.00;

        $coin = new Coin($coin_id, 'Bitcoin', 'BTC', 0, 50000.00);

        $this->cryptoCoinDataSourceMock->shouldReceive('findByCoinId')
            ->once()
            ->with($coin_id)
            ->andReturn($coin);

        $this->walletDataSourceMock->shouldReceive('get')
            ->once()
            ->with($wallet_id)
            ->andThrow(Exception::class);

        $response = $this->sellCoinService->execute($coin_id, $wallet_id, $amount_usd);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
