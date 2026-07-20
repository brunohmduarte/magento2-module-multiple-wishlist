<?php
/**
 * @category  BrunoDuarte
 * @package   BrunoDuarte_MultipleWishlist
 * @copyright Copyright (c) 2026 BrunoDuarte
 */

declare(strict_types=1);

namespace BrunoDuarte\MultipleWishlist\Controller\Page;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\RedirectFactory;
use BrunoDuarte\MultipleWishlist\Helper\Data as HelperModule;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\AuthorizationException;
use Magento\Framework\Exception\SessionException;

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
    protected SessionFactory $sessionFactory;
    protected ManagerInterface $messageManager;

    /**
     * AbstractPage constructor.
     *
     * @param PageFactory $resultPageFactory
     * @param RedirectFactory $resultRedirectFactory
     * @param HelperModule $helperModule
     * @param SessionFactory $sessionFactory
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        PageFactory $resultPageFactory,
        RedirectFactory $resultRedirectFactory,
        HelperModule $helperModule,
        SessionFactory $sessionFactory,
        ManagerInterface $messageManager
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->helperModule = $helperModule;
        $this->sessionFactory = $sessionFactory;
        $this->messageManager = $messageManager;
    }

    protected function init(): void
    {
        if (!$this->helperModule->isModuleEnable()) {
            throw new AuthorizationException(__('The multiple wishlist module is disabled.'));
        }

        $session = $this->sessionFactory->create();

        if (!$session->isLoggedIn()) {
            throw new SessionException(__('Customer is not logged in'));
        }
    }

    abstract public function execute(): ResultInterface;
}
