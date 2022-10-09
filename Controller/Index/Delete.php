<?php

namespace Dudchenko\Phones\Controller\Index;

use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Dudchenko\Phones\Api\PhoneRepositoryInterface;
use Dudchenko\Phones\Helper\Config as ConfigHelper;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

class Delete extends Action
{
    /**
     * @var ConfigHelper
     */
    protected $configHelper;

    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * @var PhoneRepositoryInterface
     */
    protected $phoneRepository;


    /**
     * @param Context $context
     * @param ResultFactory $resultFactory
     * @param ConfigHelper $configHelper
     * @param PhoneRepositoryInterface $phoneRepository
     */
    public function __construct(
        Context $context,
        ResultFactory $resultFactory,
        ConfigHelper $configHelper,
        PhoneRepositoryInterface $phoneRepository
    )
    {
        $this->resultFactory = $resultFactory;
        $this->configHelper = $configHelper;
        $this->phoneRepository = $phoneRepository;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|Forward|Forward&ResultInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\Result\Redirect&ResultInterface|ResultInterface
     */
    public function execute()
    {
        $moduleEnable = $this->configHelper->getGeneralConfig('enable');

        if ($moduleEnable == 0) {
            return $this->resultFactory->create(ResultFactory::TYPE_FORWARD)->forward('defaultNoRoute');
        }

        $id = $this->_request->getParam('entity_id');
        $this->phoneRepository->deleteById($id);

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('phones/index/');
    }
}
