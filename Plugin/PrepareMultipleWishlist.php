<?php

declare(strict_types=1);

namespace BrunoDuarte\MultipleWishlist\Plugin;

use BrunoDuarte\MultipleWishlist\Api\MultipleWishlistServiceInterface;
use BrunoDuarte\MultipleWishlist\Api\Data\MultipleWishlistInterface;
use BrunoDuarte\MultipleWishlist\Api\MultipleWishlistRepositoryInterface;

class PrepareMultipleWishlist
{
    private MultipleWishlistRepositoryInterface $multipleWishlistRepository;

    public function __construct(MultipleWishlistRepositoryInterface $multipleWishlistRepository)
    {
        $this->multipleWishlistRepository = $multipleWishlistRepository;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterCreate(
        MultipleWishlistServiceInterface $subject,
        MultipleWishlistInterface $result
    ): MultipleWishlistInterface {
        return $this->multipleWishlistRepository->getById($result->getId());
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterUpdate(
        MultipleWishlistServiceInterface $subject,
        MultipleWishlistInterface $result
    ): MultipleWishlistInterface {
        return $this->multipleWishlistRepository->getById($result->getId());
    }
}
