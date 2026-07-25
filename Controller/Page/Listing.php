<?php
/**
 * @category  BrunoDuarte
 * @package   BrunoDuarte_MultipleWishlist
 * @copyright Copyright (c) 2026 BrunoDuarte
 */

declare(strict_types=1);

namespace BrunoDuarte\MultipleWishlist\Controller\Page;

use BrunoDuarte\MultipleWishlist\Controller\Page\AbstractPage;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\SessionException;

/**
 * Class Listing
 * @package BrunoDuarte\MultipleWishlist\Controller\Page
 */
class Listing extends AbstractPage
{
    public function execute(): ResultInterface
    {
        $this->checkPermissions();

        $result = $this->resultPageFactory->create();
        $result->getConfig()->getTitle()->set(__('My Multiple Wishlists'));

        return $result;
    }
}
