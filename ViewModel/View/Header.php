<?php
/**
 * @category BrunoDuarte
 * @package BrunoDuarte_MultipleWishlist
 * @copyright 2026 BrunoDuarte
 */

declare(strict_types=1);

namespace BrunoDuarte\MultipleWishlist\ViewModel\View;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class Header implements ArgumentInterface
{
    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @param UrlInterface $urlBuilder
     */
    public function __construct(UrlInterface $urlBuilder)
    {
        $this->urlBuilder = $urlBuilder;
    }

    // public function getCreateUrl(): string
    // {
    //     return $this->urlBuilder->getUrl('multiple_wishlist/page/create');
    // }

}
