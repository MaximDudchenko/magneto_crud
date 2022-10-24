<?php

namespace Dudchenko\Phones\Controller\Adminhtml\Index;

use Dudchenko\Phones\Api\Data\PhoneInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Backend\Model\View\Result\RedirectFactory as ResultRedirectFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Dudchenko\Phones\Api\PhoneRepositoryInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

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

        try {
            $this->phoneRepository->deleteById($this->getRequest()->getParam(PhoneInterface::ENTITY_ID));

            $this->messageManager->addSuccessMessage(__('You deleted the phone.'));
        } catch (NoSuchEntityException|CouldNotDeleteException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Oops, something went wrong!'));
        }

        return $resultRedirect->setPath('*/*/');
    }
}
