<?php

namespace Dudchenko\Phones\Controller\Index;

use \Magento\Framework\App\Action\Action;
use \Magento\Framework\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;
use \Dudchenko\Phones\Model\PhoneFactory;
use Dudchenko\Phones\Api\PhoneRepositoryInterface;

class Delete extends Action
{
    protected $pageFactory;
    protected $phoneFactory;
    protected $phoneRepository;

    public function __construct(
        Context $context,
        PhoneFactory $phoneFactory,
        PageFactory $pageFactory,
    ) {
        $this->pageFactory = $pageFactory;
        $this->phoneFactory = $phoneFactory;
        parent::__construct($context);
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
