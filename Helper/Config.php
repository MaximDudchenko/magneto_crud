<?php

namespace Dudchenko\Phones\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Config extends AbstractHelper
{
    const XML_PATH_PHONES_GENERAL = 'phones_general/';

    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }

    public function getGeneralConfig($field, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_PHONES_GENERAL .'general/'. $field, $storeId);
    }

}
