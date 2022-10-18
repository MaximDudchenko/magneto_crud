<?php

namespace Dudchenko\Phones\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory as ResultPageFactory;
use Dudchenko\Phones\Helper\Config as ConfigHelper;

class Index implements HttpGetActionInterface
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
     * @param ConfigHelper $configHelper
     * @param ResultFactory $resultFactory
     */
    public function __construct(
        ConfigHelper $configHelper,
        ResultFactory $resultFactory
    ) {
        $this->resultFactory = $resultFactory;
        $this->configHelper = $configHelper;
    }

    /**
     * @return ResponseInterface|Forward|Forward&ResultInterface|ResultInterface|Page|Page&ResultInterface
     */
    public function execute()
    {
        if (!$this->configHelper->isModuleEnable()) {
            return $this->resultFactory->create(ResultFactory::TYPE_FORWARD)->forward('defaultNoRoute');
        }

        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
