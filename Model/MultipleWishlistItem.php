<?php

declare(strict_types=1);

namespace BrunoDuarte\MultipleWishlist\Model;

use BrunoDuarte\MultipleWishlist\Api\Data\MultipleWishlistItemInterface;
use BrunoDuarte\MultipleWishlist\Model\ResourceModel\MultipleWishlistItem as MultipleWishlistItemResourceModel;
use Magento\Framework\Model\AbstractModel;

class MultipleWishlistItem extends AbstractModel implements MultipleWishlistItemInterface
{
    protected $_cacheTag = 'multiple_wishlist_entity';
    protected $_eventPrefix = 'multiple_wishlist_entity';

    protected function _construct(): void
    {
        $this->_init(MultipleWishlistItemResourceModel::class);
    }

    public function getCustomerId(): ?int
    {
        $value = $this->getData(self::CUSTOMER_ID);
        return is_numeric($value) ? (int) $value : null;
    }

    public function setCustomerId(int $customerId): void
    {
        $this->setData(self::CUSTOMER_ID, $customerId);
    }

    public function getWishlistId(): ?int
    {
        $value = $this->getData(self::WISHLIST_ID);
        return is_numeric($value) ? (int) $value : null;
    }

    public function setWishlistId(int $wishlistId): void
    {
        $this->setData(self::WISHLIST_ID, $wishlistId);
    }

    public function getProductId(): ?int
    {
        $value = $this->getData(self::PRODUCT_ID);
        return is_numeric($value) ? (int) $value : null;
    }

    public function setProductId(int $productId): void
    {
        $this->setData(self::PRODUCT_ID, $productId);
    }

    public function getQty(): ?string
    {
        $value = $this->getData(self::QUANTITY);
        return is_string($value) ? $value : null;
    }

    public function setQty(string $qty): void
    {
        $this->setData(self::QUANTITY, $qty);
    }

    public function getCreatedAt(): ?string
    {
        $value = $this->getData(self::CREATED_AT);
        return is_string($value) ? $value : null;
    }

    public function setCreatedAt(string $createdAt): self
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    public function getUpdatedAt(): ?string
    {
        $value = $this->getData(self::UPDATED_AT);
        return is_string($value) ? $value : null;
    }

    public function setUpdatedAt(string $updatedAt): self
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
