<?php

namespace Dudchenko\Phones\Controller\Index;

use \Magento\Framework\App\Action\Action;
use \Magento\Framework\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;
use \Dudchenko\Phones\Model\PhoneFactory;
use Dudchenko\Phones\Api\PhoneRepositoryInterface;

class Delete extends Action
{
    protected $pageFactory;
    protected $phoneFactory;
    protected $phoneRepository;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        PhoneFactory $phoneFactory,
        PhoneRepositoryInterface $phoneRepository
    )
    {
        $this->pageFactory = $pageFactory;
        $this->phoneFactory = $phoneFactory;
        $this->phoneRepository = $phoneRepository;
        parent::__construct($context);

    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        dd($this->phoneRepository);
        $id = $this->_request->getParam('id');
        /** @var \Dudchenko\Phones\Model\Phone $phone */
        $phone = $this->phoneFactory->create();
        $phone = $this->phoneRepository->getById($id);
        dd($phone);
        $phone = $phone->setId($id);
        $phone->delete();
        return $this->_redirect('phones/index');
    }
}
