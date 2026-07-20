<?php
/**
 * @category  BrunoDuarte
 * @package   BrunoDuarte_MultipleWishlist
 * @copyright Copyright (c) 2026 BrunoDuarte
 */

declare(strict_types=1);

namespace BrunoDuarte\MultipleWishlist\ViewModel\Create;

use BrunoDuarte\MultipleWishlist\Helper\Data as HelperModule;
use BrunoDuarte\MultipleWishlist\Model\ResourceModel\MultipleWishlist\CollectionFactory as WishlistCollectionFactory;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * Class Form
 *
 * @category BrunoDuarte\MultipleWishlist\ViewModel\Create
 */
class Form implements ArgumentInterface
{
    private UrlInterface $urlBuilder;
    private HelperModule $helperModule;
    private SessionFactory $sessionFactory;
    private WishlistCollectionFactory $wishlistCollectionFactory;

    /**
     * Form constructor.
     * @param UrlInterface $urlBuilder
     * @param HelperModule $helperModule
     * @param SessionFactory $sessionFactory
     * @param WishlistCollectionFactory $wishlistCollectionFactory
     */
    public function __construct(
        UrlInterface $urlBuilder,
        HelperModule $helperModule,
        SessionFactory $sessionFactory,
        WishlistCollectionFactory $wishlistCollectionFactory
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->helperModule = $helperModule;
        $this->sessionFactory = $sessionFactory;
        $this->wishlistCollectionFactory = $wishlistCollectionFactory;
    }

    protected function getCustomerSession(): Customer
    {
        return $this->sessionFactory->create()->getCustomer();
    }

    public function getSaveUrl(): string
    {
        return $this->urlBuilder->getUrl('multiple_wishlist/post/createPost');
    }

    public function getQtyCustomerLists(): ?int
    {
        if ($this->helperModule->getMaxQtyListsByCustomer() === 0) {
            return null;
        }

        return $this->wishlistCollectionFactory->create()
            ->addFieldToFilter('customer_id', $this->getCustomerSession()->getId())
            ->getSize();
    }

    public function getMaxListsAllowed(): ?int
    {
        return $this->helperModule->getMaxQtyListsByCustomer();
    }
}
