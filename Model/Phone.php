<?php

namespace Dudchenko\Phones\Model;

use \Magento\Framework\Model\AbstractModel;
use \Magento\Framework\DataObject\IdentityInterface;

class Phone extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'dudchenko_phones';

    protected $_cacheTag = 'dudchenko_phones';

    protected $_eventPrefix = 'dudchenko_phones';

    protected function _construct()
    {
        $this->_init('Dudchenko\Phones\Model\ResourceModel\Phone');
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
        return $this->getData('brand');
    }

    public function getModel(): string
    {
        return $this->getData('model');
    }

    public function getPrice(): float
    {
        return $this->getData('price');
    }

    public function getQuantity(): int
    {
        return $this->getData('quantity');
    }
}
