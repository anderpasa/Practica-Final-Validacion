<?php
namespace App\Application\CoinService;

use App\Application\CoinDataSource\SellCoinDataSource;
use Exception;

class SellCoinService
{
    /**
     * @var SellCoinDataSource
     */
    private SellCoinDataSource $SellCoinDataSource;

    /**
     * @param SellCoinDataSource $SellCoinDataSource
     */
    public function __construct(SellCoinDataSource $SellCoinDataSource)
    {
        $this->SellCoinDataSource = $SellCoinDataSource;
    }

    /**
     * @throws Exception
     */
    public function execute(string $coin_id,string $wallet_id,float $amount_usd):SellCoinDataSource
    {
        //Llamar a la api con el coin_id
        return $this->SellCoinDataSource->SellCoin($coin_id,$wallet_id,$amount_usd);
    }

}
