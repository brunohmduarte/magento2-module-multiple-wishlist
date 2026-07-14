<?php

declare(strict_types=1);

namespace BrunoDuarte\MultipleWishlist\Model;

use Magento\Framework\Model\AbstractModel;
use BrunoDuarte\MultipleWishlist\Api\Data\MultipleWishlistInterface;
use BrunoDuarte\MultipleWishlist\Model\ResourceModel\MultipleWishlist as MultipleWishlistResourceModel;

class MultipleWishlist extends AbstractModel implements MultipleWishlistInterface
{
    protected $_cacheTag = 'multiple_wishlist_entity';
    protected $_eventPrefix = 'multiple_wishlist_entity';

    protected function _construct(): void
    {
        $this->_init(MultipleWishlistResourceModel::class);
    }

    public function getCustomerId(): ?int
    {
        $value = $this->getData(self::CUSTOMER_ID);
        return is_numeric($value) ? (int) $value : null;
    }

    public function setCustomerId(int $customerId): self
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    public function getTitle(): ?string
    {
        $value = $this->getData(self::TITLE);
        return is_string($value) ? $value : null;
    }

    public function setTitle(string $title): self
    {
        return $this->setData(self::TITLE, $title);
    }

    public function getIsActive(): ?bool
    {
        $value = $this->getData(self::IS_ACTIVE);
        return is_bool($value) ? $value : !!$value;
    }

    public function setIsActive(bool $isActive): self
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    public function getStoreId(): ?int
    {
        $value = $this->getData(self::STORE_ID);
        return is_numeric($value) ? (int) $value : null;
    }

    public function setStoreId(int $storeId): self
    {
        return $this->setData(self::STORE_ID, $storeId);
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
