<?php

namespace Dudchenko\Phones\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Magento\Framework\Pricing\Helper\Data;
use \Dudchenko\Phones\Model\Phone;
use \Dudchenko\Phones\Model\PhoneFactory;
use Dudchenko\Phones\Model\ResourceModel\Phone\CollectionFactory;


class Index extends Template
{
    protected $phoneCollectionFactory;
    protected $priceHelper;

    public function __construct(
        Context $context,
        CollectionFactory $phoneCollectionFactory,
        Data $priceHelper,
        array $data = [])
    {
        $this->phoneCollectionFactory = $phoneCollectionFactory;
        $this->priceHelper = $priceHelper;
        parent::__construct($context, $data);
    }

    public function getPhoneCollection()
    {
        /** @var \Dudchenko\Phones\Model\ResourceModel\Phone\Collection $collection */
        $collection = $this->phoneCollectionFactory->create();
        return $collection->getItems();
    }

    public function getPrice(Phone $phone)
    {
        return $this->priceHelper->currency($phone->getPrice(), includeContainer: false);
    }
}
