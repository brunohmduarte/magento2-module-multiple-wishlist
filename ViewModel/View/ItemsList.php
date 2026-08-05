<?php
/**
 * @category    BrunoDuarte
 * @package     BrunoDuarte_MultipleWishlist
 * @copyright   Copyright (c) 2026 BrunoDuarte
 */

declare(strict_types=1);

namespace BrunoDuarte\MultipleWishlist\ViewModel\View;

use BrunoDuarte\MultipleWishlist\Api\MultipleWishlistRepositoryInterface;
use BrunoDuarte\MultipleWishlist\Api\Data\MultipleWishlistInterface;
use Magento\Framework\App\RequestInterface;
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
     * @var MultipleWishlistRepositoryInterface
     */
    private MultipleWishlistRepositoryInterface $multipleWishlistRepository;

    /**
     * ItemsList constructor.
     *
     * @param RequestInterface $request
     * @param MultipleWishlistRepositoryInterface $multipleWishlistRepository
     */
    public function __construct(
        RequestInterface $request,
        MultipleWishlistRepositoryInterface $multipleWishlistRepository
    ) {
        $this->request = $request;
        $this->multipleWishlistRepository = $multipleWishlistRepository;
    }

    public function getWishlistId(): int
    {
        return (int) $this->request->getParam('id');
    }

    public function getWishlist(): MultipleWishlistInterface
    {
        return $this->multipleWishlistRepository->getById($this->getWishlistId());
    }

    public function getWishlistItems(): array
    {
        return [
            [
                'image' => 'https://placehold.co/100',
                'product_url' => '#',
                'url_remove' => '#',
                'name' => 'Product 1',
                'sku' => 'product-1',
                'price' => 100.00,
                'quantity' => 1,
            ],
            [
                'image' => 'https://placehold.co/100',
                'product_url' => '#',
                'url_remove' => '#',
                'name' => 'Product 2',
                'sku' => 'product-2',
                'price' => 100.00,
                'quantity' => 2,
            ],
            [
                'image' => 'https://placehold.co/100',
                'product_url' => '#',
                'url_remove' => '#',
                'name' => 'Product 3',
                'sku' => 'product-3',
                'price' => 100.00,
                'quantity' => 3,
            ]
        ];
    }
}
