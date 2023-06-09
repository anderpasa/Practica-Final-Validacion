<?php

namespace App\Domain;
use JsonSerializable;
class Coin implements JsonSerializable
{
    private string $coin_id;
    private string $name;
    private string $symbol;
    private float $value_usd;
    private float $amount;

    /**
     * @param string $coin_id
     * @param string $name
     * @param string $symbol
     * @param float $amount
     * @param float $value_usd
     */
    public function __construct(string $coin_id, string $name, string $symbol, float $amount, float $value_usd)
    {
        $this->coin_id = $coin_id;
        $this->name = $name;
        $this->symbol = $symbol;
        $this->amount = $amount;
        $this->value_usd = $value_usd;
    }

    /**
     * @return string
     */
    public function getCoinId(): string
    {
        return $this->coin_id;
    }

    /**
     * @param string $coin_id
     */
    public function setCoinId(string $coin_id): void
    {
        $this->coin_id = $coin_id;
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
    public function getSymbol(): string
    {
        return $this->symbol;
    }

    /**
     * @param string $symbol
     */
    public function setSymbol(string $symbol): void
    {
        $this->symbol = $symbol;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return float
     */
    public function getValueUsd(): float
    {
        return $this->value_usd;
    }

    /**
     * @param float $value_usd
     */
    public function setValueUsd(float $value_usd): void
    {
        $this->value_usd = $value_usd;
    }


    public function getJsonData()
    {
        $var = get_object_vars($this);
        return $var;
    }
    public function jsonSerialize()
    {
        return [
            'coin_id' => $this->coin_id,
            'name' => $this->name,
            'symbol' => $this->symbol,
            'value_usd' => $this->value_usd,
            'amount' => $this->amount,
        ];
    }



}
