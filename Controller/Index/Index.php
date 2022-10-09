<?php

namespace Dudchenko\Phones\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory as ResultPageFactory;
use Laminas\Mvc\Controller\Plugin\Service\ForwardFactory;
use Dudchenko\Phones\Helper\Config as ConfigHelper;

class Index extends Action
{
    /**
     * @var ConfigHelper
     */
    protected $configHelper;

    /**
     * @var ResultPageFactory
     */
    protected $resultFactory;

    /**
     * @param Context $context
     * @param ConfigHelper $configHelper
     * @param ResultFactory $resultFactory
     */
    public function __construct(
        Context $context,
        ConfigHelper $configHelper,
        ResultFactory $resultFactory
    ) {
        $this->resultFactory = $resultFactory;
        $this->configHelper = $configHelper;
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

        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
