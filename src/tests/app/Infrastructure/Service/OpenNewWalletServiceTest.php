<?php
namespace Tests\Unit;

use App\Application\Services\OpenNewWalletService;
use App\Application\WalletDataSource\WalletDataSource;
use App\Domain\Wallet;
use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;

class OpenNewWalletServiceTest extends TestCase
{
    private $openNewWalletService;
    private $walletDataSourceMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->walletDataSourceMock = Mockery::mock(WalletDataSource::class);
        $this->openNewWalletService = new OpenNewWalletService($this->walletDataSourceMock);
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testExecuteWithExistingWallet(): void
    {
        $user_id = '1';
        $wallet = new Wallet($user_id, []);

        $this->walletDataSourceMock->shouldReceive('get')
            ->once()
            ->with($user_id)
            ->andReturn($wallet);

        $result = $this->openNewWalletService->execute($user_id);

        $this->assertSame($wallet, $result);
    }

    public function testExecuteWithNewWallet(): void
    {
        $user_id = '2';
        $wallet = new Wallet($user_id, []);

        $this->walletDataSourceMock->shouldReceive('get')
            ->once()
            ->with($user_id)
            ->andThrow(Exception::class);

        $this->walletDataSourceMock->shouldReceive('add')
            ->once()
            ->with($user_id)
            ->andReturn($wallet);

        $result = $this->openNewWalletService->execute($user_id);

        $this->assertSame($wallet, $result);
    }
}
