<?php

namespace Dudchenko\Phones\Controller\Index;

use \Magento\Framework\App\Action\Action;
use \Magento\Framework\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;
use function PHPUnit\Framework\isEmpty;


class Save extends Action
{
    protected $pageFactory;
    protected $phoneFactory;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        \Dudchenko\Phones\Model\PhoneFactory $phoneFactory
    )
    {
        $this->pageFactory = $pageFactory;
        $this->phoneFactory = $phoneFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        if ($this->getRequest()->isPost()) {
            $input = $this->getRequest()->getPostValue();
            $phone = $this->phoneFactory->create();
            if (!empty($input['id'])) {
                $phone->load($input['id']);
                $phone->addData($input);
                $phone->setId($input['id']);
                $phone->save();
            } else {
                $phone->setData($input)->save();
            }
            return $this->_redirect('phones/index');
        }
    }
}
