<?php

namespace Dudchenko\Phones\ViewModel;

use Dudchenko\Phones\Model\Phone;
use Dudchenko\Phones\Model\ResourceModel\Phone\CollectionFactory;
use Magento\Framework\DataObject;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Pricing\Helper\Data as PriceHelper;

class Index implements ArgumentInterface
{
    /**
     * @var PriceHelper
     */
    protected $priceHelper;

    /**
     * @var CollectionFactory
     */
    protected $phoneCollectionFactory;


    /**
     * @param PriceHelper $priceHelper
     * @param CollectionFactory $phoneCollectionFactory
     */
    public function __construct(
        PriceHelper $priceHelper,
        CollectionFactory $phoneCollectionFactory
    )
    {
        $this->priceHelper = $priceHelper;
        $this->phoneCollectionFactory = $phoneCollectionFactory;
    }

    /**
     * @return DataObject|DataObject[]
     */
    public function getPhoneCollection()
    {
        /** @var \Dudchenko\Phones\Model\ResourceModel\Phone\Collection $collection */
        $collection = $this->phoneCollectionFactory->create();

        return $collection->getItems();
    }

    /**
     * @param Phone $phone
     * @return float|string
     */
    public function getPrice(Phone $phone)
    {
        return $this->priceHelper->currency($phone->getPrice(), includeContainer: false);
    }
}
