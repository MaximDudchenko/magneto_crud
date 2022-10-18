<?php

namespace Dudchenko\Phones\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Config extends AbstractHelper
{
    const XML_PATH_PHONES_GENERAL = 'phones_general/';

    public function isModuleEnable(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_PHONES_GENERAL . 'general/enable',
            ScopeInterface::SCOPE_STORE,
            null);
    }

}
