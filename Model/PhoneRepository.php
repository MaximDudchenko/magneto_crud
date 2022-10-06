<?php

namespace Dudchenko\Phones\Model;

use Magento\Framework\Api\DataObjectHelper;
use Dudchenko\Phones\Api\Data\PhoneInterface;
use Dudchenko\Phones\Api\Data\PhoneInterfaceFactory;
use Dudchenko\Phones\Api\PhoneRepositoryInterface;
use Dudchenko\Phones\Model\ResourceModel\Phone as ResourcePhone;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Dudchenko\Phones\Model\PhoneFactory;
use Dudchenko\Phones\Model\ResourceModel\Phone\CollectionFactory as PhoneCollectionFactory;

class PhoneRepository implements PhoneRepositoryInterface
{
    protected $resource;
    protected $phoneCollectionFactory;
    protected $searchResultsFactory;
    protected $phoneInterfaceFactory;
    protected $dataObjectHelper;


    public function __constructor(
        ResourcePhone $resource,
        PhoneCollectionFactory $phoneCollectionFactory,
        SearchCriteriaInterface $searchResultsFactory,
        PhoneInterfaceFactory $phoneInterfaceFactory,
        DataObjectHelper $dataObjectHelper
    )
    {
        $this->resource = $resource;
        $this->phoneCollectionFactory = $phoneCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->phoneInterfaceFactory = $phoneInterfaceFactory;
        $this->dataObjectHelper = $dataObjectHelper;
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
        $phone = $this->phoneInterfaceFactory->create();
        $this->resource->load($phone, $id);
        if (!$phone->getId()) {
            throw new NoSuchEntityException(__('The CMS block with the "%1" ID doesn\'t exist.', $id));
        }
        return $phone;
    }

    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Dudchenko\Phones\Api\Data\PhoneSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        /** @var \Dudchenko\Phones\Model\ResourceModel\Phone\Collection $collection */
        $collection = $this->phoneCollectionFactory->create();

        //Add filters from root filter group to the collection
        /** @var FilterGroup $group */
        foreach ($searchCriteria->getFilterGroups() as $group) {
            $this->addFilterGroupToCollection($group, $collection);
        }
        $sortOrders = $searchCriteria->getSortOrders();
        /** @var SortOrder $sortOrder */
        if ($sortOrders) {
            foreach ($searchCriteria->getSortOrders() as $sortOrder) {
                $field = $sortOrder->getField();
                $collection->addOrder(
                    $field,
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        } else {
            $field = 'entity_id';
            $collection->addOrder($field, 'ASC');
        }
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());

        $data = [];
        foreach ($collection as $datum) {
            $dataDataObject = $this->phoneInterfaceFactory->create();
            $this->dataObjectHelper->populateWithArray($dataDataObject, $datum->getData(), PhoneInterface::class);
            $data[] = $dataDataObject;
        }
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults->setItems($data);
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
