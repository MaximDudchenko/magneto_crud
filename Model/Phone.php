<?php

namespace Dudchenko\Phones\Model;

use Dudchenko\Phones\Api\Data\PhoneInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Phone extends AbstractModel implements PhoneInterface, IdentityInterface
{
    const CACHE_TAG = 'dudchenko_phones';

    protected $_cacheTag = 'dudchenko_phones';

    protected $_eventPrefix = 'dudchenko_phones';

    protected function _construct()
    {
        $this->_init(\Dudchenko\Phones\Model\ResourceModel\Phone::class);
    }

    /**
     * @inheritDoc
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getBrand(): string
    {
        return (string)$this->getData(self::BRAND);
    }

    public function getModel(): string
    {
        return (string)$this->getData(self::MODEL);
    }

    public function getPrice(): float
    {
        return (float)$this->getData(self::PRICE);
    }

    public function getQuantity(): int
    {
        return (int)$this->getData(self::QUANTITY);
    }

    public function setBrand(string $brand): PhoneInterface
    {
        return $this->setData(self::BRAND, $brand);
    }

    public function setModel(string $model): PhoneInterface
    {
        return $this->setData(self::MODEL, $model);
    }

    public function setPrice(float $price): PhoneInterface
    {
        return $this->setData(self::PRICE, $price);
    }

    public function setQuantity(int $quantity): PhoneInterface
    {
        return $this->setData(self::QUANTITY, $quantity);
    }
}
