<?php

declare(strict_types= 1);

namespace BrunoDuarte\MultipleWishlist\Api\Data;

interface MultipleWishlistItemInterface
{
    public const ENTITY_ID = 'wishlist_item_id';
    public const WISHLIST_ID = 'wishlist_id';
    public const CUSTOMER_ID = 'customer_id';
    public const QUANTITY = 'quantity';
    public const PRODUCT_ID = 'product_id';

    /**
     * @return int|null
     */
    public function getEntityId(): ?int;

    /**
     * @param int $entityId
     * @return self
     */
    public function setEntityId(int $entityId): void;

    /**
     * @return int|null
     */
    public function getWishlistId(): ?int;

    /**
     * @param int $wishlistId
     * @return self
     */
    public function setWishlistId(int $wishlistId): void;

    /**
     * @return int|null
     */
    public function getCustomerId(): ?int;

    /**
     * @param int $customerId
     * @return self
     */
    public function setCustomerId(int $customerId): void;

    public function getQty(): ?string;

    /**
     * @param int $qty
     * @return self
     */
    public function setQty(string $qty): void;

    /**
     * @return int|null
     */
    public function getProductId(): ?int;

    /**
     * @param int $productId
     * @return self
     */
    public function setProductId(int $productId): void;

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * @param string $createdAt
     * @return self
     */
    public function setCreatedAt(string $createdAt): self;

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string;

    /**
     * @param string $updatedAt
     * @return self
     */
    public function setUpdatedAt(string $updatedAt): self;
}
