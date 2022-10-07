<?php

namespace Dudchenko\Phones\ViewModel;

use Dudchenko\Phones\Api\Data\PhoneInterface;
use Dudchenko\Phones\Api\PhoneRepositoryInterface;
use Dudchenko\Phones\Model\Phone;
use Magento\Framework\Registry as CoreRegistry;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Pricing\Helper\Data as PriceHelper;

class Edit implements ArgumentInterface
{
    /**
     * @var PriceHelper
     */
    protected $priceHelper;

    /**
     * @var CoreRegistry
     */
    protected $coreRegistry;

    /**
     * @var PhoneRepositoryInterface
     */
    protected $phoneRepository;

    /**
     * @param PriceHelper $priceHelper
     * @param CoreRegistry $coreRegistry
     * @param PhoneRepositoryInterface $phoneRepository
     */
    public function __construct(
        PriceHelper $priceHelper,
        CoreRegistry $coreRegistry,
        PhoneRepositoryInterface $phoneRepository
    )
    {
        $this->priceHelper = $priceHelper;
        $this->coreRegistry = $coreRegistry;
        $this->phoneRepository = $phoneRepository;
    }

    /**
     * @return PhoneInterface
     */
    public function getPhone()
    {
        $id = $this->coreRegistry->registry('editRecordId');
        return $this->phoneRepository->getById($id);
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
