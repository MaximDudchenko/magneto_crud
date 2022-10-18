<?php

namespace Dudchenko\Phones\Api;

use Dudchenko\Phones\Api\Data\PhoneInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface PhoneRepositoryInterface
{
    /**
     * @param  PhoneInterface $phone
     * @return PhoneInterface
     */
    public function save(PhoneInterface $phone): PhoneInterface;

    /**
     * @param int|null $id
     * @return PhoneInterface
     */
    public function getById($id): PhoneInterface;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Dudchenko\Phones\Api\Data\PhoneSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param PhoneInterface $phone
     * @return bool
     */
    public function delete(PhoneInterface $phone): bool;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById($id): bool;
}
