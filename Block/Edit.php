<?php

namespace Dudchenko\Phones\Block;

use Dudchenko\Phones\Model\Phone;
use \Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use \Magento\Framework\Registry;

class Edit extends Template
{
    protected $phoneFactory;
    protected $coreRegistry;

    public function __construct(
        Context $context,
        \Dudchenko\Phones\Model\PhoneFactory $phoneFactory,
        Registry $registry,
        array $data = [])
    {
        $this->phoneFactory = $phoneFactory;
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    public function getPhone()
    {
        $id = $this->coreRegistry->registry('editRecordId');
        $phone = $this->phoneFactory->create();
        $result = $phone->load($id);
        return $result;
    }
}
