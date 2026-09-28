<?php
/**
 * @category  BrunoDuarte
 * @package   BrunoDuarte_MultipleWishlist
 * @copyright Copyright (c) 2026 BrunoDuarte
 */

declare(strict_types=1);

namespace BrunoDuarte\MultipleWishlist\Controller\Ajax;

use BrunoDuarte\MultipleWishlist\Model\ResourceModel\MultipleWishlist\CollectionFactory as MultipleWishlistCollectionFactory;
use BrunoDuarte\MultipleWishlist\Model\ResourceModel\MultipleWishlist\Collection as MultipleWishlistCollection;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;

class GetListOptionsSelectField implements ActionInterface
{
    protected JsonFactory $resultJsonFactory;
    protected MultipleWishlistCollectionFactory $multipleWishlistCollectionFactory;

    public function __construct(
        JsonFactory $resultJsonFactory,
        MultipleWishlistCollectionFactory $multipleWishlistCollectionFactory
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->multipleWishlistCollectionFactory = $multipleWishlistCollectionFactory;
    }

    public function execute()
    {
        $result = $this->resultJsonFactory->create();

        $data = [];
        $data['success'] = false;
        $data['wishlists'] = [];

        if (empty($this->getMultipleWishlistList())) {
            return $result->setData($data);
        }

        $data['success'] = true;
        foreach ($this->getMultipleWishlistList() as $wishlist) {
            array_push($data['wishlists'], [
                "id"   => $wishlist->getWishlistId(),
                "name" => $wishlist->getTitle()
            ]);
        }

        return $result->setData($data);
    }

    /**
     * Get a multiple wishlist list active order by title.
     *
     * @return MultipleWishlistCollection
     */
    public function getMultipleWishlistList()
    {
        /** @var MultipleWishlistCollection $wishlistActiveCollection */
        $wishlistActiveCollection = $this->multipleWishlistCollectionFactory->create();

        // $wishlistActiveCollection->addFieldToFilter('is_active', '1')->addOrder('title', 'asc');
        return $wishlistActiveCollection->getMultipleWishlistList();
    }
}
