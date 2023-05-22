<?php
namespace App\Application\CoinService;

use App\Application\CoinDataSource\BuyCoinDataSource;
use Exception;

class BuyCoinService
{
    /**
     * @var BuyCoinDataSource
     */
    private BuyCoinDataSource $BuyCoinDataSource;

    /**
     * @param BuyCoinDataSource $BuyCoinDataSource
     */
    public function __construct(BuyCoinDataSource $BuyCoinDataSource)
    {
        $this->BuyCoinDataSource = $BuyCoinDataSource;
    }

    /**
     * @throws Exception
     */
    public function execute(string $coin_id,string $wallet_id,float $amount_usd): BuyCoinDataSource
    {
        //Llamar a la api con el coin_id
        return $this->BuyCoinDataSource->buyCoin($coin_id,$wallet_id,$amount_usd);
    }
}
