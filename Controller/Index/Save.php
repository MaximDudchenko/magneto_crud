<?php

namespace Dudchenko\Phones\Controller\Index;

use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Dudchenko\Phones\Model\PhoneFactory;
use Dudchenko\Phones\Api\PhoneRepositoryInterface;
use Magento\Backend\Model\View\Result\RedirectFactory as ResultRedirectFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;


class Save extends Action
{
    /**
     * @var ResultRedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * @var PhoneFactory
     */
    protected $phoneFactory;

    /**
     * @var PhoneRepositoryInterface
     */
    protected $phoneRepository;

    /**
     * @param Context $context
     * @param ResultRedirectFactory $resultRedirectFactory
     * @param PhoneFactory $phoneFactory
     * @param PhoneRepositoryInterface $phoneRepository
     */
    public function __construct(
        Context $context,
        ResultRedirectFactory $resultRedirectFactory,
        PhoneFactory $phoneFactory,
        PhoneRepositoryInterface $phoneRepository
    )
    {
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->phoneFactory = $phoneFactory;
        $this->phoneRepository = $phoneRepository;
        return parent::__construct($context);
    }

    /**
     * @return Redirect|ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($this->getRequest()->isPost()) {
            $input = $this->getRequest()->getPostValue();
            if ($input) {
                $input['entity_id'] = empty($input['entity_id']) ? null  : $input['entity_id'];
                $id = $input['entity_id'];

                /** @var \Dudchenko\Phones\Model\Phone $phone */
                $phone = $this->phoneFactory->create();

                if ($id) {
                    $phone = $this->phoneRepository->getById($id);
                }

                $phone->setData($input);

                $this->phoneRepository->save($phone);
            }
            return $resultRedirect->setPath('phones/index/');
        }
    }
}
