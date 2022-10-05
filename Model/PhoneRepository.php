<?php

namespace Dudchenko\Phones\Model;

use Dudchenko\Phones\Api\Data\PhoneInterface;
use Dudchenko\Phones\Api\PhoneRepositoryInterface;
use Dudchenko\Phones\Model\ResourceModel\Phone as ResourcePhone;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class PhoneRepository implements PhoneRepositoryInterface
{
    protected $phoneFactory;
    protected $resource;


    /**
     * @param ResourcePhone $resource
     * @param \Dudchenko\Phones\Model\PhoneFactory $phoneFactory
     * @return void
     */
    public function __constructor(
        ResourcePhone $resource,
        \Dudchenko\Phones\Model\PhoneFactory $phoneFactory
    )
    {
        $this->resource = $resource;
        $this->phoneFactory = $phoneFactory;
    }


    public function save(PhoneInterface $phone): PhoneInterface
    {
        try {
            $this->resource->save($phone);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $phone;
    }

    public function getById($id): PhoneInterface
    {
        $phone = $this->phoneFactory->create();
        $this->resource->load($phone, $id);
        if (!$phone->getId()) {
            throw new NoSuchEntityException(__('The CMS block with the "%1" ID doesn\'t exist.', $id));
        }
        return $phone;
    }

    public function delete(PhoneInterface $phone): bool
    {
        try {
            $this->resource->delete($phone);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    public function deleteById($id): bool
    {
        return $this->delete($this->getById($id));
    }
}
