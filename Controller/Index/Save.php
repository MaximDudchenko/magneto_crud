<?php

namespace Dudchenko\Phones\Controller\Index;

use Dudchenko\Phones\Api\Data\PhoneInterface;
use Magento\Backend\Model\View\Result\Redirect;
use Dudchenko\Phones\Model\PhoneFactory;
use Dudchenko\Phones\Api\PhoneRepositoryInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;



class Save implements HttpPostActionInterface
{
    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * @var PhoneFactory
     */
    protected $phoneFactory;

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
     * @param PhoneFactory $phoneFactory
     * @param PhoneRepositoryInterface $phoneRepository
     * @param RequestInterface $request
     * @param MessageManagerInterface $messageManager
     */
    public function __construct(
        ResultFactory $resultFactory,
        PhoneFactory $phoneFactory,
        PhoneRepositoryInterface $phoneRepository,
        RequestInterface $request,
        MessageManagerInterface $messageManager
    )
    {
        $this->resultFactory = $resultFactory;
        $this->phoneFactory = $phoneFactory;
        $this->phoneRepository = $phoneRepository;
        $this->request = $request;
        $this->messageManager = $messageManager;
    }

    /**
     * @return Redirect|ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        $input = $this->request->getParams();

        if (!$input) {
            return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/');
        }

        /** @var \Dudchenko\Phones\Model\Phone $phone */
        $phone = $this->phoneFactory->create();
        $id = $this->request->getParam(PhoneInterface::ENTITY_ID);
        try {
            if ($id) {
                $phone = $this->phoneRepository->getById($id);
            }

            $phone->setData($input);

            $this->phoneRepository->save($phone);

            $this->messageManager->addSuccessMessage(__('You saved the phone.'));

            return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/');
        } catch (NoSuchEntityException|CouldNotSaveException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Oops, something went wrong!'));
        }
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/edit', [PhoneInterface::ENTITY_ID => $id]);
    }
}
