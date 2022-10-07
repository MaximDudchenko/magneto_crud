<?php

namespace Dudchenko\Phones\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Backend\Model\View\Result\RedirectFactory as ResultRedirectFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Dudchenko\Phones\Api\PhoneRepositoryInterface;

class Delete extends Action
{
    /**
     * @var ResultRedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * @var PhoneRepositoryInterface
     */
    protected $phoneRepository;


    /**
     * @param Context $context
     * @param ResultRedirectFactory $resultRedirectFactory
     * @param PhoneRepositoryInterface $phoneRepository
     */
    public function __construct(
        Context $context,
        ResultRedirectFactory $resultRedirectFactory,
        PhoneRepositoryInterface $phoneRepository
    )
    {
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->phoneRepository = $phoneRepository;
        parent::__construct($context);
    }

    /**
     * @return Redirect|ResponseInterface|ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $id = $this->getRequest()->getParam('entity_id');
        if ($id) {
            try {
                $this->phoneRepository->deleteById($id);

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
