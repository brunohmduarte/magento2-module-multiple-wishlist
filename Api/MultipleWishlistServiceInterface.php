<?php

declare(strict_types=1);

namespace BrunoDuarte\MultipleWishlist\Api;

use BrunoDuarte\MultipleWishlist\Api\Data\MultipleWishlistInterface;

interface MultipleWishlistServiceInterface
{
    /**
     * @param int $wishlistId
     * @return MultipleWishlistInterface
     */
    public function getById(int $wishlistId): MultipleWishlistInterface;

    /**
     * @param int $customerId
     * @return MultipleWishlistInterface[]
     */
    public function getByCustomerId(int $customerId): array;
}
