<?php

namespace Dudchenko\Phones\ViewModel;

use Dudchenko\Phones\Api\Data\PhoneInterface;
use Dudchenko\Phones\Api\PhoneRepositoryInterface;
use Dudchenko\Phones\Model\Phone;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Pricing\Helper\Data as PriceHelper;

class Edit implements ArgumentInterface
{
    /**
     * @var PriceHelper
     */
    protected $priceHelper;

    /**
     * @var PhoneRepositoryInterface
     */
    protected $phoneRepository;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @param PriceHelper $priceHelper
     * @param PhoneRepositoryInterface $phoneRepository
     * @param RequestInterface $request
     */
    public function __construct(
        PriceHelper $priceHelper,
        PhoneRepositoryInterface $phoneRepository,
        RequestInterface $request
    )
    {
        $this->priceHelper = $priceHelper;
        $this->phoneRepository = $phoneRepository;
        $this->request = $request;
    }

    /**
     * @return PhoneInterface
     */
    public function getPhone()
    {
        return $this->phoneRepository->getById($this->request->getParam('entity_id'));
    }

    /**
     * @param Phone $phone
     * @return float|string
     */
    public function getPrice(Phone $phone)
    {
        return $this->priceHelper->currency($phone->getPrice(), false, false);
    }
}
