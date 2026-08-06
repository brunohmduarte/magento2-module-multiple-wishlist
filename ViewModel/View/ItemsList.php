<?php
/**
 * @category    BrunoDuarte
 * @package     BrunoDuarte_MultipleWishlist
 * @copyright   Copyright (c) 2026 BrunoDuarte
 */

declare(strict_types=1);

namespace BrunoDuarte\MultipleWishlist\ViewModel\View;

use BrunoDuarte\MultipleWishlist\Api\MultipleWishlistRepositoryInterface;
use BrunoDuarte\MultipleWishlist\Api\MultipleWishlistItemRepositoryInterface;
use BrunoDuarte\MultipleWishlist\Api\Data\MultipleWishlistItemInterface;
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

    /**
     * @var MultipleWishlistItemRepositoryInterface
     */
    private MultipleWishlistItemRepositoryInterface $multipleWishlistItemRepository;

    /**
     * @var MultipleWishlistRepositoryInterface
     */
    private MultipleWishlistRepositoryInterface $multipleWishlistRepository;

    /**
     * @var ManagerInterface
     */
    private ManagerInterface $messageManager;

    /**
     * ItemsList constructor.
     *
     * @param RequestInterface $request
     * @param MultipleWishlistItemRepositoryInterface $multipleWishlistItemRepository
     * @param MultipleWishlistRepositoryInterface $multipleWishlistRepository
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        RequestInterface $request,
        MultipleWishlistItemRepositoryInterface $multipleWishlistItemRepository,
        MultipleWishlistRepositoryInterface $multipleWishlistRepository,
        ManagerInterface $messageManager
    ) {
        $this->request = $request;
        $this->multipleWishlistItemRepository = $multipleWishlistItemRepository;
        $this->multipleWishlistRepository = $multipleWishlistRepository;
        $this->messageManager = $messageManager;
    }

    public function getWishlistId(): int
    {
        return (int) $this->request->getParam('id');
    }

    public function wishlistExists()
    {
        $wishlistId = $this->getWishlistId();
        if (empty($wishlistId)) {
            throw new \InvalidArgumentException(__('Wishlist ID is missing.'));
        }

        try {
            $wishlist = $this->multipleWishlistRepository->getById($wishlistId);
            if (!$wishlist) {
                throw new \InvalidArgumentException(__('Wishlist not found.'));
            }
        } catch (NoSuchEntityException $e) {
            throw new \InvalidArgumentException(__('Wishlist not found.'));
        }
    }

    public function getWishlistItems(): ?MultipleWishlistItemInterface
    {
        try {
            $this->wishlistExists();

            $wishlistItems = $this->multipleWishlistItemRepository->getById($this->getWishlistId());
            if (empty($wishlistItems)) {
                throw new \InvalidArgumentException(__('Wishlist items not found.'));
            }

            return $wishlistItems;
            
        } catch (\InvalidArgumentException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return null;
        }

        // return [
        //     [
        //         'image' => 'https://placehold.co/100',
        //         'product_url' => '#',
        //         'url_remove' => '#',
        //         'name' => 'Product 1',
        //         'sku' => 'product-1',
        //         'price' => 100.00,
        //         'quantity' => 1,
        //     ],
        //     [
        //         'image' => 'https://placehold.co/100',
        //         'product_url' => '#',
        //         'url_remove' => '#',
        //         'name' => 'Product 2',
        //         'sku' => 'product-2',
        //         'price' => 100.00,
        //         'quantity' => 2,
        //     ],
        //     [
        //         'image' => 'https://placehold.co/100',
        //         'product_url' => '#',
        //         'url_remove' => '#',
        //         'name' => 'Product 3',
        //         'sku' => 'product-3',
        //         'price' => 100.00,
        //         'quantity' => 3,
        //     ]
        // ];
    }

    public function getBackUrl(): string
    {
        return '/multiple_wishlist/page/listing/';
    }
}
