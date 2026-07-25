<?php
/**
 * @category  BrunoDuarte
 * @package   BrunoDuarte_MultipleWishlist
 * @copyright Copyright (c) 2026 BrunoDuarte
 */

declare(strict_types=1);

namespace BrunoDuarte\MultipleWishlist\Controller\Page;

use BrunoDuarte\MultipleWishlist\Helper\Data as HelperModule;
use Magento\Customer\Model\Session;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Exception\AuthorizationException;
use Magento\Framework\Exception\SessionException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Abstract AbstractPage
 *
 * @package BrunoDuarte\MultipleWishlist\Controller\Page
 */
abstract class AbstractPage implements ActionInterface
{
    protected PageFactory $resultPageFactory;
    protected RedirectFactory $resultRedirectFactory;
    protected HelperModule $helperModule;
    protected Session $session;
    protected ManagerInterface $messageManager;

    /**
     * AbstractPage constructor.
     *
     * @param PageFactory $resultPageFactory
     * @param RedirectFactory $resultRedirectFactory
     * @param HelperModule $helperModule
     * @param Session $session
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        PageFactory $resultPageFactory,
        RedirectFactory $resultRedirectFactory,
        HelperModule $helperModule,
        Session $session,
        ManagerInterface $messageManager
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->helperModule = $helperModule;
        $this->session = $session;
        $this->messageManager = $messageManager;
    }

    protected function checkPermissions()
    {
        if (!$this->helperModule->isModuleEnable()) {
            $this->messageManager->addErrorMessage(__("The multiple wishlist module is disabled."));
            return $this->resultRedirectFactory->create()->setPath('customer/account/');
        }

        if (!$this->session->isLoggedIn()) {
            $this->messageManager->addErrorMessage(__('Customer is not logged in'));
            return $this->resultRedirectFactory->create()->setPath('customer/account/login');
        }
    }

    abstract public function execute(): ResultInterface;
}
