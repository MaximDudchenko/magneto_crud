<?php

namespace Dudchenko\Phones\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Magento\Framework\Pricing\Helper\Data;
use \Dudchenko\Phones\Model\Phone;
use \Dudchenko\Phones\Model\PhoneFactory;


class Index extends Template
{
    protected $phoneFactory;
    protected $priceHelper;

    public function __construct(
        Context $context,
        PhoneFactory $phoneFactory,
        Data $priceHelper,
        array $data = [])
    {
        $this->phoneFactory = $phoneFactory;
        $this->priceHelper = $priceHelper;
        parent::__construct($context, $data);
    }

    public function getPhoneCollection()
    {
        $collection = $this->phoneFactory->create();
        return $collection->getCollection();
    }

    public function getPrice(Phone $phone)
    {
        return $this->priceHelper->currency($phone->getPrice(), includeContainer: false);
    }
}
