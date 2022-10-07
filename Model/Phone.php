<?php

namespace Dudchenko\Phones\Model;

use Dudchenko\Phones\Api\Data\PhoneInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Phone extends AbstractModel implements PhoneInterface, IdentityInterface
{
    const CACHE_TAG = 'dudchenko_phones';

    /**
     * @var string
     */
    protected $_cacheTag = 'dudchenko_phones';

    /**
     * @var string
     */
    protected $_eventPrefix = 'dudchenko_phones';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Dudchenko\Phones\Model\ResourceModel\Phone::class);
    }

    /**
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return string
     */
    public function getBrand(): string
    {
        return (string)$this->getData(self::BRAND);
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return (string)$this->getData(self::MODEL);
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return (float)$this->getData(self::PRICE);
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return (int)$this->getData(self::QUANTITY);
    }

    /**
     * @param string $brand
     * @return PhoneInterface
     */
    public function setBrand(string $brand): PhoneInterface
    {
        return $this->setData(self::BRAND, $brand);
    }

    /**
     * @param string $model
     * @return PhoneInterface
     */
    public function setModel(string $model): PhoneInterface
    {
        return $this->setData(self::MODEL, $model);
    }

    /**
     * @param float $price
     * @return PhoneInterface
     */
    public function setPrice(float $price): PhoneInterface
    {
        return $this->setData(self::PRICE, $price);
    }

    /**
     * @param int $quantity
     * @return PhoneInterface
     */
    public function setQuantity(int $quantity): PhoneInterface
    {
        return $this->setData(self::QUANTITY, $quantity);
    }
}
