<?php
/**
 * @category    BrunoDuarte
 * @package     BrunoDuarte_MultipleWishlist
 * @copyright   Copyright (c) 2026 BrunoDuarte
 */

declare(strict_types=1);

namespace BrunoDuarte\MultipleWishlist\Controller\Page;

use BrunoDuarte\MultipleWishlist\Controller\Page\AbstractPage;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\SessionException;

/**
 * Class Create
 *
 * @package BrunoDuarte\MultipleWishlist\Controller\Page
 */
class Create extends AbstractPage
{
    public function execute(): ResultInterface
    {
        try {
            $this->checkPermissions();

            $result = $this->resultPageFactory->create();
            $result->getConfig()->getTitle()->set(__('Create Multiple Wishlists')->render());
        } catch (SessionException $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
            $result = $this->resultRedirectFactory->create();
            $result->setPath('customer/account/login/')->setHttpResponseCode(301);
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
            $result = $this->resultRedirectFactory->create();
            $result->setPath('customer/account/')->setHttpResponseCode(301);
        }

        return $result;
    }
}
