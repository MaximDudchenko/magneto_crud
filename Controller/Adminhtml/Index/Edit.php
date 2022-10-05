<?php

namespace Dudchenko\Phones\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use \Magento\Backend\App\Action\Context;
use \Magento\Framework\Registry;
use \Magento\Framework\View\Result\PageFactory;
use \Dudchenko\Phones\Model\PhoneFactory;

class Edit extends Action
{
    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * @var PhoneFactory
     */
    protected $phoneFactory;

    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $pageFactory
     * @param PhoneFactory $phoneFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $pageFactory,
        PhoneFactory $phoneFactory
    ) {
        $this->pageFactory = $pageFactory;
        $this->phoneFactory = $phoneFactory;
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');

        /** @var \Dudchenko\Phones\Model\Phone $phone */
        $phone = $this->phoneFactory->create();

        if ($id) {
            $phone->load($id);
            if (!$phone->getId()) {
                $this->messageManager->addErrorMessage(__('This phone not exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->coreRegistry->register('phone', $phone);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->pageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend($phone->getId() ? $phone->getBrand() . ' ' . $phone->getModel() : __('New Phone'));
        return $resultPage;
    }
}
