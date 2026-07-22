<?php

declare(strict_types= 1);

namespace BrunoDuarte\MultipleWishlist\Model\ResourceModel\MultipleWishlist;

use BrunoDuarte\MultipleWishlist\Model\MultipleWishlist as MultipleWishlistModel;
use BrunoDuarte\MultipleWishlist\Model\ResourceModel\MultipleWishlist as MultipleWishlistResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(MultipleWishlistModel::class, MultipleWishlistResourceModel::class);
    }
}
