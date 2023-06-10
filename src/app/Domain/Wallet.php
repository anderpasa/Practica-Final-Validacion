<?php

namespace App\Domain;

class Wallet
{
    private string $wallet_id;
    private string $name;
    private string $id_usuario;
    private array $coins = [];

    private float $value_usd;

    /**
     * @param string $wallet_id
     * @param array $coins
     */

    public function __construct(string $wallet_id, array $coins)
    {
        $this->wallet_id = $wallet_id;
        $this->coins = $coins;
    }

    /**
     * @return string
     */
    public function getWalletId(): string
    {
        return $this->wallet_id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getIdUsuario(): string
    {
        return $this->id_usuario;
    }

    /**
     * @param string $id_usuario
     */
    public function setIdUsuario(string $id_usuario): void
    {
        $this->id_usuario = $id_usuario;
    }

    /**
     * @return array
     */
    public function getCoins(): array
    {
        //print("holi" . $this->coins[0]->getCoinId() . "\n");
        return $this->coins;
    }

    /**
     * @param array $coins
     */
    /*
     * public function setCoins(array $coins): void
    {
        $this->coins = array_merge($this->coins, $coins);

    }
*/
    public function setCoins(array $newCoins): void
    {
        foreach ($newCoins as $newCoin) {
            $found = false;
            foreach ($this->coins as &$existingCoin) {
                if ($existingCoin->getCoinId() === $newCoin->getCoinId()) {
                    $existingCoin->setAmount($existingCoin->getAmount() + $newCoin->getAmount());
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $this->coins[] = $newCoin;
            }
        }
    }




}
