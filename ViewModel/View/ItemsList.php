<?php
/**
 * @category    BrunoDuarte
 * @package     BrunoDuarte_MultipleWishlist
 * @copyright   Copyright (c) 2026 BrunoDuarte
 */

declare(strict_types=1);

namespace BrunoDuarte\MultipleWishlist\ViewModel\View;

use BrunoDuarte\MultipleWishlist\Api\MultipleWishlistRepositoryInterface;
use BrunoDuarte\MultipleWishlist\Model\ResourceModel\MultipleWishlistItem\CollectionFactory as MultipleWishlistItemCollectionFactory;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * ItemsList
 *
 * @package BrunoDuarte\MultipleWishlist\ViewModel\View
 * @implements ArgumentInterface
 */
class ItemsList implements ArgumentInterface
{
    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    private MultipleWishlistItemCollectionFactory $multipleWishlistItemCollectionFactory;

    /**
     * @var MultipleWishlistRepositoryInterface
     */
    private MultipleWishlistRepositoryInterface $multipleWishlistRepository;

    /**
     * @var ManagerInterface
     */
    private ManagerInterface $messageManager;

    /**
     * @var ProductFactory
     */
    private ProductFactory $productFactory;

    /**
     * ItemsList constructor.
     *
     * @param RequestInterface $request
     * @param MultipleWishlistItemCollectionFactory $multipleWishlistItemCollectionFactory
     * @param MultipleWishlistRepositoryInterface $multipleWishlistRepository
     * @param ManagerInterface $messageManager
     * @param ProductFactory $productFactory
     */
    public function __construct(
        RequestInterface $request,
        MultipleWishlistItemCollectionFactory $multipleWishlistItemCollectionFactory,
        MultipleWishlistRepositoryInterface $multipleWishlistRepository,
        ManagerInterface $messageManager,
        ProductFactory $productFactory
    ) {
        $this->request = $request;
        $this->multipleWishlistItemCollectionFactory = $multipleWishlistItemCollectionFactory;
        $this->multipleWishlistRepository = $multipleWishlistRepository;
        $this->messageManager = $messageManager;
        $this->productFactory = $productFactory;
    }

    public function getWishlistId(): int
    {
        return (int) $this->request->getParam('id');
    }

    /**
     * Get the wishlist name.
     *
     * @return string|null
     */
    public function getWishlistTitle(): string
    {
        return $this->multipleWishlistRepository->getById($this->getWishlistId())->getTitle();
    }


    /**
     * Check if wishlist exists
     *
     * @throws \InvalidArgumentException
     * @return void
     */
    public function wishlistExists()
    {
        $wishlistId = $this->getWishlistId();
        if (empty($wishlistId)) {
            throw new \InvalidArgumentException('Wishlist ID is missing.');
        }

        try {
            $wishlist = $this->multipleWishlistRepository->getById($wishlistId);
            if (empty($wishlist)) {
                throw new \InvalidArgumentException('Wishlist not found.');
            }
        } catch (NoSuchEntityException $e) {
            throw new \InvalidArgumentException('Wishlist not found.');
        }
    }

    /**
     * Get wishlist the products
     *
     * @return array|null
     */
    public function getWishlistItems(): ?array
    {
        try {
            $this->wishlistExists();

            $wishlistItems = $this->multipleWishlistItemCollectionFactory->create();
            $wishlistItems->addFieldToFilter('wishlist_id', $this->getWishlistId());

            $products = [];
            foreach ($wishlistItems as $wishlistItem) {
                $productId = (int) $wishlistItem->getProductId();
                $product = $this->productFactory->create()->load($productId);
                if (!$product->getId()) {
                    throw new \InvalidArgumentException('Product not found for the wishlist item.');
                }

                $productData = array_merge($product->getData(), $wishlistItem->getData());
                $productData['swatch_image'] = $productData['swatch_image'] ?? $productData['image'] ?? '';
                $productData['_product'] = $product;
                $products[] = $productData;
            }

            return $products === [] ? [] : ['product' => $products];
        } catch (\InvalidArgumentException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return null;
        }
    }

}
