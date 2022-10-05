<?php

namespace Dudchenko\Phones\Api\Data;

interface PhoneInterface
{
    const ENTITY_ID = 'entity_id';
    const BRAND = 'brand';
    const MODEL = 'model';
    const PRICE = 'price';
    const QUANTITY = 'quantity';

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return string
     */
    public function getBrand(): string;

    /**
     * @return string
     */
    public function getModel(): string;

    /**
     * @return float
     */
    public function getPrice(): float;

    /**
     * @return int
     */
    public function getQuantity(): int;

    /**
     * @param mixed $value
     * @return mixed
     */
    public function setId($value);

    /**
     * @param string $brand
     * @return PhoneInterface
     */
    public function setBrand(string $brand): PhoneInterface;

    /**
     * @param string $model
     * @return PhoneInterface
     */
    public function setModel(string $model): PhoneInterface;

    /**
     * @param float $price
     * @return mixed
     */
    public function setPrice(float $price): PhoneInterface;

    /**
     * @param int $quantity
     * @return PhoneInterface
     */
    public function setQuantity(int $quantity): PhoneInterface;
}
