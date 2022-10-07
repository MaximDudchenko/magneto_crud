<?php

namespace Dudchenko\Phones\Model;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Dudchenko\Phones\Model\ResourceModel\Phone\Collection;
use Dudchenko\Phones\Model\ResourceModel\Phone\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        /** @var \Dudchenko\Phones\Model\Phone $phone */
        foreach ($items as $phone) {
            $this->loadedData[$phone->getId()] = $phone->getData();
        }

        $data = $this->dataPersistor->get('phone');
        if (!empty($data)) {
            $phone = $this->collection->getNewEmptyItem();
            $phone->setData($data);
            $this->loadedData[$phone->getId()] = $phone->getData();
            $this->dataPersistor->clear('phone');
        }

        return $this->loadedData;
    }
}
