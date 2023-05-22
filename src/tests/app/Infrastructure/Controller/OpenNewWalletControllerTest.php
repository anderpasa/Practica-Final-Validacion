<?php

namespace Tests\app\Infrastructure\Controller;

use App\Domain\Wallet;
use Couchbase\WatchQueryIndexesOptions;
use Mockery;
use App\Application\WalletDataSource\WalletDataSource;
use Tests\TestCase;

class OpenNewWalletControllerTest extends TestCase
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
    public function walletServiceUnavailable()
    {
        $this->walletDataSource
            ->expects('add')
            ->with(null)
            ->times(0);

        $response = $this->post('/api/wallet/open');

        $response->assertExactJson(['error' => 'user_id mandatory']);
    }

    /**
     * @test
     */
    public function walletCreation()
    {
        $id = "1";      //Se tiene una única variable de id porque el usuario al sólo poder disponer de una cartera, no es necesario el que haya 2 variables, una para el id del usuario y otra para la cartera porque coinciden en que son la misma
        $this->walletDataSource
            ->expects('add')
            ->with($id)
            ->andReturn(new Wallet($id, []));

        $response = $this->post('/api/wallet/open', ["user_id" => $id]);

        $response->assertExactJson(['wallet_id' => $id]);
    }

    /**
     * @test
     *//*
    public function getExistingWallets()
    {
        $id = "1";
        $this->walletDataSource
            ->expects('add')        //Se puede hacer un segundo mockery para hacer el get?
            ->with($id)
            ->andReturn(new Wallet($id, []));

        $response = $this->post('/api/wallet/open', ["user_id" => $id]);

        $response->assertExactJson(['wallet_id' => $id]);
    }
*/
}

