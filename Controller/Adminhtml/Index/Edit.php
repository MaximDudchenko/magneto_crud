<?php

namespace Dudchenko\Phones\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry as CoreRegistry;
use Magento\Framework\View\Result\PageFactory as ResultPageFactory;
use Dudchenko\Phones\Model\PhoneFactory;
use Dudchenko\Phones\Api\PhoneRepositoryInterface;

class Edit extends Action
{
    /**
     * @var ResultPageFactory
     */
    protected $resultPageFactory;

    /**
     * @var PhoneFactory
     */
    protected $phoneFactory;

    /**
     * @var CoreRegistry
     */
    protected $coreRegistry;

    /**
     * @var PhoneRepositoryInterface
     */
    protected $phoneRepository;

    /**
     * @param Context $context
     * @param CoreRegistry $coreRegistry
     * @param ResultPageFactory $resultPageFactory
     * @param PhoneFactory $phoneFactory
     * @param PhoneRepositoryInterface $phoneRepository
     */
    public function __construct(
        Context $context,
        CoreRegistry $coreRegistry,
        ResultPageFactory $resultPageFactory,
        PhoneFactory $phoneFactory,
        PhoneRepositoryInterface $phoneRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->phoneFactory = $phoneFactory;
        $this->coreRegistry = $coreRegistry;
        $this->phoneRepository = $phoneRepository;
        parent::__construct($context);
    }

    /**
     * @return Page|Redirect|ResponseInterface|ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');

        /** @var \Dudchenko\Phones\Model\Phone $phone */
        $phone = $this->phoneFactory->create();

        if ($id) {
            $phone = $this->phoneRepository->getById($id);
            if (!$phone->getId()) {
                $this->messageManager->addErrorMessage(__('This phone not exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->coreRegistry->register('phone', $phone);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend($phone->getId() ? $phone->getBrand() . ' ' . $phone->getModel() : __('New Phone'));
        return $resultPage;
    }
}
