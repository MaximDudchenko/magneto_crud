<?php

namespace Dudchenko\Phones\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry as CoreRegistry;
use Magento\Framework\View\Result\Page;
use Magento\Framework\Controller\ResultFactory;
use Dudchenko\Phones\Helper\Config as ConfigHelper;

class Edit extends Action
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
     * @var CoreRegistry
     */
    protected $coreRegistry;

    /**
     * @param Context $context
     * @param ResultFactory $resultPageFactory
     * @param ConfigHelper $configHelper
     * @param CoreRegistry $coreRegistry
     */
    public function __construct(
        Context $context,
        ResultFactory $resultPageFactory,
        ConfigHelper $configHelper,
        CoreRegistry $coreRegistry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->configHelper = $configHelper;
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|Forward|Forward&ResultInterface|ResultInterface|Page|Page&ResultInterface
     */
    public function execute()
    {
        $moduleEnable = $this->configHelper->getGeneralConfig('enable');

        if ($moduleEnable == 0) {
            return $this->resultFactory->create(ResultFactory::TYPE_FORWARD)->forward('defaultNoRoute');
        }

        $id = $this->_request->getParam('entity_id');
        $this->coreRegistry->register('editRecordId', $id);

        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
