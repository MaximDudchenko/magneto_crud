<?php

namespace Dudchenko\Phones\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Dudchenko\Phones\Model\PhoneFactory;
use \Magento\Backend\Model\View\Result\RedirectFactory;

class Save extends Action implements HttpPostActionInterface
{
    protected $redirectFactory;
    protected $coreRegistry;
    protected $dataPersistor;
    protected $phoneFactory;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     * @param RedirectFactory $redirectFactory
     * @param PhoneFactory $blockFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        RedirectFactory $redirectFactory,
        PhoneFactory $phoneFactory
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->dataPersistor = $dataPersistor;
        $this->redirectFactory = $redirectFactory;
        $this->phoneFactory = $phoneFactory;
        parent::__construct($context);
        $this->messageManager->getMessages(true);
    }

    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->redirectFactory->create();
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
                    $phone->load($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This phone no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $phone->setData($input);

            try {
                $phone->save();
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
