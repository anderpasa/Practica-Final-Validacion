<?php

namespace Tests\Unit;

use App\Application\Services\CriptocurrenciesService;
use App\Application\Services\CriptocurriencesService;
use App\Application\WalletDataSource\WalletDataSource;
use App\Domain\Wallet;
use Exception;
use Illuminate\Http\Response;
use Mockery;
use Tests\TestCase;

class CriptocurrenciesServiceTest extends TestCase
{
    private $cryptocurrenciesService;
    private $walletDataSourceMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->walletDataSourceMock = Mockery::mock(WalletDataSource::class);
        $this->cryptocurrenciesService = new CriptocurriencesService($this->walletDataSourceMock);
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testExecute(): void
    {
        $wallet_id = '1';
        $wallet = new Wallet($wallet_id,[]);

        $this->walletDataSourceMock->shouldReceive('get')
            ->once()
            ->with($wallet_id)
            ->andThrow(new Exception("Wallet not found"));


        $response = $this->cryptocurrenciesService->execute($wallet_id);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testExecuteWithInvalidWalletId(): void
    {
        $wallet_id = 'invalid_wallet_id';

        $this->walletDataSourceMock->shouldReceive('get')
            ->once()
            ->with($wallet_id)
            ->andThrow(Exception::class);

        $response = $this->cryptocurrenciesService->execute($wallet_id);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testExecuteWithWalletNotFound(): void
    {
        $wallet_id = '1';

        $wallet = new Wallet($wallet_id, []);
        $this->walletDataSourceMock->shouldReceive('get')
            ->once()
            ->with($wallet_id)
            ->andReturn($wallet);

        $response = $this->cryptocurrenciesService->execute($wallet_id);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }


}
