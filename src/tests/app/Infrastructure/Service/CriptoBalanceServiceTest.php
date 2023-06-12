<?php
namespace Tests\Unit;

use App\Application\Services\CriptoBalanceService;
use App\Application\CoinDataSource\CryptoCoinDataSource;
use App\Application\WalletDataSource\WalletDataSource;
use App\Domain\Coin;
use App\Domain\Wallet;
use Exception;
use Illuminate\Http\Response;
use Mockery;
use Tests\TestCase;

class CriptoBalanceServiceTest extends TestCase
{
    private $criptoBalanceService;
    private $walletDataSourceMock;
    private $cryptoCoinDataSourceMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->walletDataSourceMock = Mockery::mock(WalletDataSource::class);
        $this->cryptoCoinDataSourceMock = Mockery::mock(CryptoCoinDataSource::class);
        $this->criptoBalanceService = new CriptoBalanceService($this->walletDataSourceMock, $this->cryptoCoinDataSourceMock);
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testExecute(): void
    {
        $wallet_id = '1';
        $coin = new Coin('90','Bitcoin','BTC',2,50000.00);
        $wallet = new Wallet($wallet_id,[$coin]);

        $this->walletDataSourceMock->shouldReceive('get')
            ->once()
            ->with($wallet_id)
            ->andReturn($wallet);

        $this->cryptoCoinDataSourceMock->shouldReceive('findByCoinId')
            ->once()
            ->with($coin->getCoinId())
            ->andReturn($coin);

        $response = $this->criptoBalanceService->execute($wallet_id);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(['balance_usd' => 50000], $response->getData(true));
    }

    public function testExecuteWithInvalidWalletId(): void
    {
        $wallet_id = 'invalid_wallet_id';

        $this->walletDataSourceMock->shouldReceive('get')
            ->once()
            ->with($wallet_id)
            ->andThrow(Exception::class);

        $response = $this->criptoBalanceService->execute($wallet_id);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertEquals(['error' => 'wallet_id mandatory'], $response->getData(true));
    }
}

