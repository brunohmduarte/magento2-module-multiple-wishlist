<?php
/**
 * @category  BrunoDuarte
 * @package   BrunoDuarte_MultipleWishlist
 * @copyright Copyright (c) 2026 BrunoDuarte
 */

declare(strict_types= 1);

namespace BrunoDuarte\MultipleWishlist\Model\ResourceModel\MultipleWishlist;

use Magento\Framework\ObjectManagerInterface;
use BrunoDuarte\MultipleWishlist\Model\MultipleWishlist;

/**
 * Multiple Wishlist Collection factory
 */
class CollectionFactory
{
    /**
     * Object Manager instance
     *
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * CollectionFactory constructor.
     *
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return MultipleWishlist
     */
    public function create(array $data = [])
    {
        return $this->objectManager->create(MultipleWishlist::class, $data);
    }
}
