<?php

declare(strict_types=1);

namespace BrunoDuarte\MultipleWishlist\Helper;

use Magento\Catalog\Helper\Image as ImageHelper;
use Magento\Catalog\Model\Product;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\UrlInterface;

class Url extends AbstractHelper
{
    private UrlInterface $urlBuilder;
    private ImageHelper $imageHelper;

    public function __construct(
        Context $context,
        UrlInterface $urlBuilder,
        ImageHelper $imageHelper
    ) {
        parent::__construct($context);
        $this->urlBuilder = $urlBuilder;
        $this->imageHelper = $imageHelper;
    }

    public function getRouteUrl(string $route, array $params = []): string
    {
        return $this->urlBuilder->getUrl($route, $params);
    }

    public function getProductUrl(Product $product): string
    {
        return $product->getProductUrl();
    }

    public function getProductImageUrl(Product $product, ?string $image = null): string
    {
        if ($image && filter_var($image, FILTER_VALIDATE_URL)) {
            return $image;
        }

        $imageHelper = $this->imageHelper->init($product, 'product_page_image_small');
        if ($image && $image !== 'no_selection') {
            $imageHelper->setImageFile($image);
        }

        return $imageHelper->getUrl();
    }

    public function getRemoveFromWishlistUrl(Product $product): string
    {
        return $this->urlBuilder->getUrl('multiplewishlist/index/remove', ['product_id' => $product->getId()]);
    }
}
