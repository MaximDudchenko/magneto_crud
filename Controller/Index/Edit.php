<?php

namespace Dudchenko\Phones\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Edit extends Action
{
    protected $pageFactory;
    protected $coreRegistry;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        \Magento\Framework\Registry $registry,
    ) {
        $this->pageFactory = $pageFactory;
        $this->coreRegistry = $registry;
        return parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->_request->getParam('id');
        $this->coreRegistry->register('editRecordId', $id);
        return $this->pageFactory->create();
    }
}
