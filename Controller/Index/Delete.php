<?php

namespace Dudchenko\Phones\Controller\Index;

use \Magento\Framework\App\Action\Action;
use \Magento\Framework\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;
use \Dudchenko\Phones\Model\Phone;
use \Dudchenko\Phones\Model\PhoneFactory;

class Delete extends Action
{
    protected $phoneFactory;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        PhoneFactory $phoneFactory
    ) {
        $this->pageFactory = $pageFactory;
        $this->phoneFactory = $phoneFactory;
        return parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $id = $this->_request->getParam('id');
        $phone = $this->phoneFactory->create();
        $phone = $phone->setId($id);
        $phone->delete();
        return $this->_redirect('phones/index');
    }
}
