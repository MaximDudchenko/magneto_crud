<?php

namespace Dudchenko\Phones\Controller\Index;

use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Dudchenko\Phones\Api\PhoneRepositoryInterface;
use Magento\Backend\Model\View\Result\RedirectFactory as ResultRedirectFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

class Delete extends Action
{
    protected $resultRedirectFactory;

    /**
     * @var PhoneRepositoryInterface
     */
    protected $phoneRepository;

    /**
     * @param Context $context
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

        $id = $this->_request->getParam('entity_id');
        $this->phoneRepository->deleteById($id);

        return $resultRedirect->setPath('phones/index/');
    }
}
