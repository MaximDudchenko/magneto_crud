<?php

namespace Dudchenko\Phones\Model\ResourceModel\Phone;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'dudchenko_phones_collection';
    protected $_eventObject = 'phones_collection';

    protected function _construct()
    {
        $this->_init(\Dudchenko\Phones\Model\Phone::class, \Dudchenko\Phones\Model\ResourceModel\Phone::class);
    }
}
