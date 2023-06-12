<?php

namespace Tests\Unit;

use App\Application\CoinDataSource\CryptoCoinDataSource;
use App\Domain\Coin;
use Exception;
use Tests\TestCase;
use Mockery;

class CryptoCoinDataSourceTest extends TestCase
{
    protected $cryptoCoinDataSource;

    public function setUp(): void
    {
        parent::setUp();

        $this->cryptoCoinDataSource = Mockery::mock('overload:App\Application\CoinDataSource\CryptoCoinDataSource');
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testFindByCoinId(): void
    {
        $coin_id = '90';
        $coin = new Coin($coin_id,'Bitcoin','BTC',0,50000.00);

        $this->cryptoCoinDataSource->shouldReceive('findByCoinId')
            ->once()
            ->with($coin_id)
            ->andReturn($coin);

        $result = $this->cryptoCoinDataSource->findByCoinId($coin_id);

        $this->assertInstanceOf(Coin::class, $result);
        $this->assertEquals($coin_id, $result->getCoinId());
        $this->assertEquals($coin, $result);
    }

    public function testFindByCoinIdWithException(): void
    {
        $this->expectException(Exception::class);

        $coin_id = 'invalid_coin_id';

        $this->cryptoCoinDataSource->shouldReceive('findByCoinId')
            ->once()
            ->with($coin_id)
            ->andThrow(Exception::class);

        $this->cryptoCoinDataSource->findByCoinId($coin_id);
    }
}
