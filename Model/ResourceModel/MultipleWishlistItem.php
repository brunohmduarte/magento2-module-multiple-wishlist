<?php

declare(strict_types=1);

namespace BrunoDuarte\MultipleWishlist\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class MultipleWishlistItem extends AbstractDb
{
    protected function _construct(): void
    {
        $this->_init('multiple_wishlist_item', 'wishlist_item_id');
    }
}
