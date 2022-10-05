<?php

namespace Dudchenko\Phones\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Dudchenko\Phones\Model\PhoneFactory;

class Delete extends Action
{

    protected $redirectFactory;
    protected $phoneFactory;

    public function __construct(
        Context $context,
        RedirectFactory $redirectFactory,
        PhoneFactory $phoneFactory
    )
    {
        $this->redirectFactory = $redirectFactory;
        $this->phoneFactory = $phoneFactory;
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $id = $this->getRequest()->getParam('entity_id');
        if ($id) {
            try {
                /** @var \Dudchenko\Phones\Model\Phone $phone */
                $phone = $this->phoneFactory->create();
                $phone->load($id);
                $phone->delete();

                $this->messageManager->addSuccessMessage(__('You deleted the phone.'));

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {

                $this->messageManager->addErrorMessage($e->getMessage());

                return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
            }
        }

        $this->messageManager->addErrorMessage(__('We can\'t find a phone to delete.'));

        return $resultRedirect->setPath('*/*/');
    }
}
