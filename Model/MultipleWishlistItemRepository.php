<?php

declare(strict_types=1);

namespace BrunoDuarte\MultipleWishlist\Model;

use BrunoDuarte\MultipleWishlist\Api\MultipleWishlistItemRepositoryInterface;
use BrunoDuarte\MultipleWishlist\Model\ResourceModel\MultipleWishlistItem as MultipleWishlistItemResourceModel;

class MultipleWishlistItemRepository implements MultipleWishlistItemRepositoryInterface
{
    private MultipleWishlistItemFactory $multipleWishlistItemFactory;
    private MultipleWishlistItemResourceModel $resourceModelMultipleWishlistItem;

    public function __construct(
        MultipleWishlistItemFactory $multipleWishlistItemFactory,
        MultipleWishlistItemResourceModel $resourceModelMultipleWishlistItem
    ) {
        $this->multipleWishlistItemFactory = $multipleWishlistItemFactory;
        $this->resourceModelMultipleWishlistItem = $resourceModelMultipleWishlistItem;
    }

    public function save(MultipleWishlistItem $multipleWishlistItem): MultipleWishlistItem
    {
        try {
            $this->resourceModelMultipleWishlistItem->save($multipleWishlistItem);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(
                __('Unable to save object. Error: %1', $exception->getMessage())
            );
        }

        return $multipleWishlistItem;
    }
}
