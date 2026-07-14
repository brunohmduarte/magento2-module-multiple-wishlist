<?php

declare(strict_types=1);

namespace BrunoDuarte\MultipleWishlist\Model;

use BrunoDuarte\MultipleWishlist\Model\MultipleWishlistItem;

class MultipleWishlistItemFactory
{
    /**
     * Create multiple wishlist
     *
     * @return MultipleWishlistItem
     */
    public function create(): MultipleWishlistItem
    {
        return new MultipleWishlistItem();
    }
}
