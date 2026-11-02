<?php

declare(strict_types=1);

namespace BrunoDuarte\MultipleWishlist\Model\ResourceModel\MultipleWishlistItem;

use BrunoDuarte\MultipleWishlist\Model\MultipleWishlistItem as MultipleWishlistItemModel;
use BrunoDuarte\MultipleWishlist\Model\ResourceModel\MultipleWishlistItem as MultipleWishlistItemResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(MultipleWishlistItemModel::class, MultipleWishlistItemResourceModel::class);
    }
}
