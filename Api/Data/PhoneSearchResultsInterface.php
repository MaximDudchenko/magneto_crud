<?php

namespace Dudchenko\Phones\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface PhoneSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get data list.
     *
     * @return \Dudchenko\Phones\Api\Data\PhoneInterface[]
     */
    public function getItems();

    /**
     * Set data list.
     *
     * @param \Dudchenko\Phones\Api\Data\PhoneInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
