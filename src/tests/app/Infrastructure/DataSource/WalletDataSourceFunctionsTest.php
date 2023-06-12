<?php

namespace Tests\app\Infrastructure\Service;

namespace Tests\Unit;

use App\Application\CoinDataSource\CryptoCoinDataSource;
use App\Application\DataSources\CoinDataSource;
use App\Application\WalletDataSource\WalletDataSource;
use App\Application\WalletDataSource\WalletDataSourceFunctions;
use App\Domain\Coin;
use App\Domain\Wallet;
use Illuminate\Support\Facades\Cache;
use Mockery;
use PHPUnit\Framework\TestCase;



class WalletDataSourceFunctionsTest extends TestCase
{
    protected $walletDataSource;

    protected function setUp(): void {
        parent::setUp();

        // Mock the Cache Facade
        $this->cacheMock = Mockery::mock('overload:'.Cache::class);
        $this->walletDataSource = new WalletDataSourceFunctions();
    }

    /**
     * @test
     */
    public function testAdd() {

        $wallet_id = '1';
        $wallet = new Wallet($wallet_id,[]);

        // Expectations for the cache mock
        $this->cacheMock->shouldReceive('put')
            ->once()
            ->with('wallet'.$wallet_id, Mockery::any());

        $this->cacheMock->shouldReceive('get')
            ->once()
            ->with('wallet'.$wallet_id)
            ->andReturn($wallet);

        // Call the method under test
        $result = $this->walletDataSource->add($wallet_id);

        // Assertions
        $this->assertInstanceOf(Wallet::class, $result);

        $this->assertEquals($wallet_id, $result->getIdUsuario());
        $this->assertEquals($wallet, Cache::get('wallet'.$wallet_id));
    }

    /**
     * @test
     */
    public function testGet() {
        $user_id = '1';
        $wallet = new Wallet($user_id,[]);

        $this->cacheMock->shouldReceive('has')
            ->once()
            ->with('wallet'.$user_id)
            ->andReturn(true);

        $this->cacheMock->shouldReceive('get')
            ->once()
            ->with('wallet'.$user_id)
            ->andReturn($wallet);

        $result = $this->walletDataSource->get($user_id);

        $this->assertInstanceOf(Wallet::class, $result);
        $this->assertEquals($wallet, $result);
    }

    /**
     * @test
     */
    public function testInsertCoin() {
        $user_id = '1';
        $wallet = new Wallet($user_id,[]);
        $coin = new Coin(1, "BlackCoin", "BLK", 1, 15);
        $amount_usd = 1;

        $this->cacheMock->shouldReceive('put')
            ->once()
            ->with('wallet'.$user_id, Mockery::any());

        $this->walletDataSource->insertCoin($wallet, $coin, $amount_usd);

        // Assume that you have a method getCoins() that returns the array of coins in the wallet
        $coins = $wallet->getCoins();

        // Check that the array of coins contains the inserted coin
        $this->assertContains($coin, $coins);

        // Assume that you have a method getAmount() that returns the amount of a coin in the wallet
        $coinAmount = $coin->getAmount();

        // Check that the amount of the coin in the wallet is correct
        $this->assertEquals($amount_usd, $coinAmount);
    }



    public function testSellCoin() {
        $wallet_id = '1';
        $coin_id = '1';
        $coin = new Coin(1, "BlackCoin", "BLK", 1, 15);
        $wallet = new Wallet($wallet_id, [$coin]);
        $amount_usd = 50;

        // Assume that Cache::get will be called and will return the Wallet object
        $this->cacheMock->shouldReceive('get')
            ->once()
            ->with('wallet'.$wallet_id)
            ->andReturn($wallet);

        // Assume that Cache::put will be called with the Wallet object
        $this->cacheMock->shouldReceive('put')
            ->once()
            ->with('wallet'.$wallet_id, Mockery::type(Wallet::class));

        // Call sellCoin method
        $this->walletDataSource->sellCoin($wallet, $coin, $amount_usd);

        // Check if coin is still in the wallet
        $this->assertContains($coin, $wallet->getCoins());

        // Check if coin amount is correct
        $filteredCoins = array_filter(
            $wallet->getCoins(),
            fn($c) => $c->getCoinId() === $coin_id
        );

        if (!empty($filteredCoins)) {
            $coinInWallet = $filteredCoins[0];
            $this->assertEquals($coin->getAmount(), $coinInWallet->getAmount());
        } else {
            $this->fail('No coin with the provided coin_id was found in the wallet.');
        }
    }




    protected function tearDown(): void {
        Mockery::close();

        parent::tearDown();
    }
}
