<?php

namespace App\Infrastructure\Providers;

use App\Application\WalletDataSource\WalletDataSource;
use App\Application\WalletDataSource\WalletDataSourceFunctions;
use App\DataSource\Database\EloquentUserDataSource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(WalletDataSource::class, function (){
            return new WalletDataSourceFunctions();
        });
//        $this->app->bind(UserRepository::class, function () {
//            return new EloquentUserDataSource();
//        });
    }
}
