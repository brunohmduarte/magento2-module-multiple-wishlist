<?php
/**
 * @category BrunoDuarte
 * @package BrunoDuarte_MultipleWishlist
 * @copyright Copyright (c) 2026 BrunoDuarte
 */

declare(strict_types=1);

namespace BrunoDuarte\MultipleWishlist\ViewModel\Listing;

use Magento\Framework\UrlInterface;

/**
 * class Header
 *
 * @package BrunoDuarte\MultipleWishlist\ViewModel\Listing
 */
class Header implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    private UrlInterface $urlBuilder;

    /**
     * Header constructor.
     *
     * @param UrlInterface $urlBuilder
     */
    public function __construct(UrlInterface $urlBuilder)
    {
        $this->urlBuilder = $urlBuilder;
    }

    public function getCreateUrl(): string
    {
        return $this->urlBuilder->getUrl('multiple_wishlist/page/create');
    }
}
