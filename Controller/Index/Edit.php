<?php

namespace Dudchenko\Phones\Controller\Index;

use Dudchenko\Phones\Api\Data\PhoneInterface;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\Page;
use Magento\Framework\Controller\ResultFactory;
use Dudchenko\Phones\Helper\Config as ConfigHelper;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;
use Dudchenko\Phones\Api\PhoneRepositoryInterface;

class Edit implements HttpGetActionInterface
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
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var MessageManagerInterface
     */
    protected $messageManager;

    /**
     * @param ResultFactory $resultFactory
     * @param ConfigHelper $configHelper
     * @param PhoneRepositoryInterface $phoneRepository
     * @param RequestInterface $request
     * @param MessageManagerInterface $messageManager
     */
    public function __construct(
        ResultFactory $resultFactory,
        ConfigHelper $configHelper,
        PhoneRepositoryInterface $phoneRepository,
        RequestInterface $request,
        MessageManagerInterface $messageManager
    ) {
        $this->resultFactory = $resultFactory;
        $this->configHelper = $configHelper;
        $this->phoneRepository = $phoneRepository;
        $this->request = $request;
        $this->messageManager = $messageManager;
    }


    /**
     * @return ResponseInterface|Forward|Forward&ResultInterface|Redirect|Redirect&ResultInterface|ResultInterface|Page|Page&ResultInterface
     */
    public function execute()
    {
        if (!$this->configHelper->isModuleEnable()) {
            return $this->resultFactory->create(ResultFactory::TYPE_FORWARD)->forward('defaultNoRoute');
        }

        $id = $this->request->getParam(PhoneInterface::ENTITY_ID);

        try {
            /** @var \Dudchenko\Phones\Model\Phone $phone */
            $phone = $this->phoneRepository->getById($id);

            return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__('This phone not exists.'));
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/');


    }
}
