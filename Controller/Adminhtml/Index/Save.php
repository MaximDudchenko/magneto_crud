<?php

namespace Dudchenko\Phones\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
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

        if ($input) {
            if (empty($input['entity_id'])) {
                $input['entity_id'] = null;
            }

            /** @var \Dudchenko\Phones\Model\Phone $phone */
            $phone = $this->phoneFactory->create();

            $id = $this->getRequest()->getParam('entity_id');
            if ($id) {
                try {
                    $this->phoneRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This phone no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $phone->setData($input);

            try {
                $this->phoneRepository->save($phone);
                $this->messageManager->addSuccessMessage(__('You saved the phone.'));
                $this->dataPersistor->clear('phone');
                return $this->redirect($resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the phone.'));
            }

            $this->dataPersistor->set('phone', $input);
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    private function redirect($resultRedirect)
    {
        $redirect = $data['back'] ?? 'close';

        if ($redirect === 'close') {
            $resultRedirect->setPath('*/*/');
        }

        return $resultRedirect;
    }
}
