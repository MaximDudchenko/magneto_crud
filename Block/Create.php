<?php

namespace Dudchenko\Phones\Block;

use \Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Create extends Template
{
    protected $phoneFactory;

    public function __construct(
        Context $context,
        \Dudchenko\Phones\Model\PhoneFactory $phoneFactory,
        array $data = [])
    {
        $this->phoneFactory = $phoneFactory;
        parent::__construct($context, $data);
    }
}
