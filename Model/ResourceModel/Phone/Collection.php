<?php

namespace Dudchenko\Phones\Model\ResourceModel\Phone;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * @var string
     */
    protected $_eventPrefix = 'dudchenko_phones_collection';

    /**
     * @var string
     */
    protected $_eventObject = 'phones_collection';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Dudchenko\Phones\Model\Phone::class, \Dudchenko\Phones\Model\ResourceModel\Phone::class);
    }
}
