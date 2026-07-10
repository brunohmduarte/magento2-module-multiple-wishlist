<?php

declare(strict_types=1);

namespace BrunoDuarte\MultipleWishlist\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    public const MODULE_REGISTRATION = 'Bistwobis_MultipleWishlist';

    private const MULTIPLE_WISHLIST_MODULE_ENABLE = 'multiple_wishlist/general/enabled';
    private const MULTIPLE_WISHLIST_MODULE_TITLE = 'multiple_wishlist/general/title';
    private const MULTIPLE_WISHLIST_AVAILABLE_CUSTOMER_GROUPS = 'multiple_wishlist/general/available_customer_groups';

    public function isModuleEnable(?int $storeId = null): bool
    {
        return $this->_moduleManager->isEnabled(self::MODULE_REGISTRATION) && $this->scopeConfig->isSetFlag(
            self::MULTIPLE_WISHLIST_MODULE_ENABLE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function getModuleTitle(?int $storeId = null): string
    {
        return $this->scopeConfig->getValue(
            self::MULTIPLE_WISHLIST_MODULE_TITLE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function getAvailableCustomerGroups(?int $storeId = null): array
    {
        return explode(
            ',',
            $this->scopeConfig->getValue(
                self::MULTIPLE_WISHLIST_AVAILABLE_CUSTOMER_GROUPS,
                ScopeInterface::SCOPE_STORE,
                $storeId
            )
        );
    }
}
