<?php

declare(strict_types=1);

namespace BrunoDuarte\MultipleWishlist\Model\ResourceModel\MultipleWishlistItem;

use Magento\Framework\ObjectManagerInterface;

class CollectionFactory
{
    private ObjectManagerInterface $objectManager;

    public function __construct(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function create(array $data = []): Collection
    {
        return $this->objectManager->create(Collection::class, $data);
    }
}
