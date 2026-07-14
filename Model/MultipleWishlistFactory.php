<?php

declare(strict_types=1);

namespace BrunoDuarte\MultipleWishlist\Model;

use BrunoDuarte\MultipleWishlist\Model\MultipleWishlist;

class MultipleWishlistFactory
{
    /**
     * Create multiple wishlist
     *
     * @return MultipleWishlist
     */
    public function create(): MultipleWishlist
    {
        return new MultipleWishlist();
    }
}
