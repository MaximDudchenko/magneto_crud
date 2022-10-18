<?php

namespace Dudchenko\Phones\Controller\Index;

use Dudchenko\Phones\Api\Data\PhoneInterface;
use Dudchenko\Phones\Api\PhoneRepositoryInterface;
use Dudchenko\Phones\Helper\Config as ConfigHelper;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;
use Magento\Framework\App\Action\Context;

class Delete implements HttpPostActionInterface
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
     */
    public function __construct(
        ResultFactory $resultFactory,
        ConfigHelper $configHelper,
        PhoneRepositoryInterface $phoneRepository,
        RequestInterface $request,
        MessageManagerInterface $messageManager
    )
    {
        $this->resultFactory = $resultFactory;
        $this->configHelper = $configHelper;
        $this->phoneRepository = $phoneRepository;
        $this->request = $request;
        $this->messageManager = $messageManager;
    }

    /**
     * @return ResponseInterface|Forward|Forward&ResultInterface|Redirect|Redirect&ResultInterface|ResultInterface
     */
    public function execute()
    {
        if (!$this->configHelper->isModuleEnable()) {
            return $this->resultFactory->create(ResultFactory::TYPE_FORWARD)->forward('defaultNoRoute');
        }

        try {
            $this->phoneRepository->deleteById($this->request->getParam(PhoneInterface::ENTITY_ID));

            $this->messageManager->addSuccessMessage(__('You deleted the phone.'));
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__('We can\'t find a phone to delete.'));
        } catch (CouldNotDeleteException $e) {
            $this->messageManager->addErrorMessage(__('We can\'t delete a phone.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/');
    }
}
