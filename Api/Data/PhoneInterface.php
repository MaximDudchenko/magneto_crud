<?php

namespace Dudchenko\Phones\Api\Data;

use DateTime;

interface PhoneInterface
{
    const ENTITY_ID = 'entity_id';
    const BRAND = 'brand';
    const MODEL = 'model';
    const PRICE = 'price';
    const QUANTITY = 'quantity';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

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
     * @return DateTime
     */
    public function getCreatedAt(): DateTime;

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime;

    /**
     * @param mixed $value
     * @return mixed
     */
    public function setId($value);

    /**
     * @param string $brand
     * @return mixed
     */
    public function setBrand(string $brand);

    /**
     * @param string $model
     * @return mixed
     */
    public function setModel(string $model);

    /**
     * @param float $price
     * @return mixed
     */
    public function setPrice(float $price);

    /**
     * @param int $quantity
     * @return mixed
     */
    public function setQuantity(int $quantity);

    /**
     * @param DateTime $created_at
     * @return mixed
     */
    public function setCreatedAt(DateTime $created_at);

    /**
     * @param DateTime $updated_at
     * @return mixed
     */
    public function setUpdatedAt(DateTime $updated_at);
}
