<?php

namespace Dudchenko\Phones\Controller\Adminhtml\Index;

use Dudchenko\Phones\Api\Data\PhoneInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry as CoreRegistry;
use Dudchenko\Phones\Model\PhoneFactory;
use Magento\Backend\Model\View\Result\RedirectFactory as ResultRedirectFactory;
use Dudchenko\Phones\Api\PhoneRepositoryInterface;

class Save extends Action implements HttpPostActionInterface
{
    /**
     * @var ResultRedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * @var CoreRegistry
     */
    protected $coreRegistry;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var PhoneFactory
     */
    protected $phoneFactory;

    /**
     * @var PhoneRepositoryInterface
     */
    protected  $phoneRepository;


    /**
     * @param Context $context
     * @param CoreRegistry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     * @param ResultRedirectFactory $resultRedirectFactory
     * @param PhoneFactory $phoneFactory
     * @param PhoneRepositoryInterface $phoneRepository
     */
    public function __construct(
        Context $context,
        CoreRegistry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        ResultRedirectFactory $resultRedirectFactory,
        PhoneFactory $phoneFactory,
        PhoneRepositoryInterface $phoneRepository
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->dataPersistor = $dataPersistor;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->phoneFactory = $phoneFactory;
        $this->phoneRepository = $phoneRepository;
        parent::__construct($context);
        $this->messageManager->getMessages(true);
    }

    /**
     * @return Redirect|ResponseInterface|ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $input = $this->getRequest()->getPostValue();

        if (!$input) {
            return $resultRedirect->setPath('*/*/');
        }

        /** @var \Dudchenko\Phones\Model\Phone $phone */
        $phone = $this->phoneFactory->create();
        $id = $this->getRequest()->getParam(PhoneInterface::ENTITY_ID);
        try {
            if ($id) {
                $phone = $this->phoneRepository->getById($id);
            }

            $phone->setData($input);

            $this->phoneRepository->save($phone);

            $this->messageManager->addSuccessMessage(__('You saved the phone.'));

            $this->dataPersistor->clear('phone');

            return $resultRedirect->setPath('*/*/');;
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__('We can\'t find a phone'));
        } catch (CouldNotSaveException $e) {
            $this->messageManager->addErrorMessage(__('We can\'t save a phone'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        $this->dataPersistor->set('phone', $input);
        return $resultRedirect->setPath('*/*/edit', [PhoneInterface::ENTITY_ID => $id]);
    }
}
