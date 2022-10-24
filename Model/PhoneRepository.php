<?php

namespace Dudchenko\Phones\Model;

use Dudchenko\Phones\Api\Data\PhoneSearchResultsInterface;
use Magento\Framework\Api\DataObjectHelper;
use Dudchenko\Phones\Api\PhoneRepositoryInterface;
use Dudchenko\Phones\Api\Data\PhoneInterface;
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
    /**
     * @var ResourcePhone
     */
    protected $resource;

    /**
     * @var PhoneCollectionFactory
     */
    protected $phoneCollectionFactory;

    /**
     * @var SearchCriteriaInterface
     */
    protected $searchResultsFactory;

    /**
     * @var PhoneFactory
     */
    protected $phoneFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;


    /**
     * @param ResourcePhone $resource
     * @param PhoneCollectionFactory $phoneCollectionFactory
     * @param SearchCriteriaInterface $searchResultsFactory
     * @param PhoneFactory $phoneFactory
     * @param DataObjectHelper $dataObjectHelper
     */
    public function __construct(
        ResourcePhone $resource,
        PhoneCollectionFactory $phoneCollectionFactory,
        SearchCriteriaInterface $searchResultsFactory,
        PhoneFactory $phoneFactory,
        DataObjectHelper $dataObjectHelper
    )
    {
        $this->resource = $resource;
        $this->phoneCollectionFactory = $phoneCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->phoneFactory = $phoneFactory;
        $this->dataObjectHelper = $dataObjectHelper;
    }

    /**
     * @param PhoneInterface $phone
     * @return PhoneInterface
     * @throws CouldNotSaveException
     */
    public function save(PhoneInterface $phone): PhoneInterface
    {
        try {
            $this->resource->save($phone);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__('Phone with the "%1" ID can\'t save', $phone->getId()));
        }
        return $phone;
    }

    /**
     * @param $id
     * @return PhoneInterface
     * @throws NoSuchEntityException
     */
    public function getById($id): PhoneInterface
    {
        /** @var \Dudchenko\Phones\Model\Phone $phone */
        $phone = $this->phoneFactory->create();

        $this->resource->load($phone, $id);

        if (!$phone->getId()) {
            throw new NoSuchEntityException(__('Phone with the "%1" ID doesn\'t exist.', $id));
        }
        return $phone;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return PhoneSearchResultsInterface
     */
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

    /**
     * @param PhoneInterface $phone
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(PhoneInterface $phone): bool
    {
        try {
            $this->resource->delete($phone);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__('Phone with the "%1" ID can\'t delete', $phone->getId()));
        }
        return true;
    }

    /**
     * @param $id
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($id): bool
    {
        return $this->delete($this->getById($id));
    }
}
