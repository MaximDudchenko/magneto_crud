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
     * @param int $id
     * @return PhoneInterface
     */
    public function getById($id): PhoneInterface;

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
