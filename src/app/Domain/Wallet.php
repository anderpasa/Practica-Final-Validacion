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
     * @param string $name
     * @param string $id_usuario
     * @param array $coins
     */
    public function __construct(string $wallet_id, string $name, string $id_usuario, array $coins, )
    {
        $this->wallet_id = $wallet_id;
        $this->name = $name;
        $this->id_usuario = $id_usuario;
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
     * @param string $wallet_id
     */
    public function setWalletId(string $wallet_id): void
    {
        $this->wallet_id = $wallet_id;
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
        return $this->coins;
    }

    /**
     * @param array $coins
     */
    public function setCoins(array $coins): void
    {
        $this->coins = $coins;
    }




}
