<?php
/**
 * @category  BrunoDuarte
 * @package   BrunoDuarte_MultipleWishlist
 * @copyright Copyright (c) 2026 BrunoDuarte
 */

declare(strict_types=1);

namespace BrunoDuarte\MultipleWishlist\Controller\Post;

use BrunoDuarte\MultipleWishlist\Api\MultipleWishlistRepositoryInterface;
use BrunoDuarte\MultipleWishlist\Api\Data\MultipleWishlistInterface;
use BrunoDuarte\MultipleWishlist\Controller\Post\AbstractPost;
use BrunoDuarte\MultipleWishlist\Helper\Data;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class SaveInfoPost
 * @package BrunoDuarte\MultipleWishlist\Controller\Post
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class SaveInfoPost extends AbstractPost
{
    protected MultipleWishlistRepositoryInterface $multipleWishlistRepository;

    /**
     * SaveInfoPost constructor.
     * 
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        RedirectFactory $resultRedirectFactory,
        RedirectInterface $redirect,
        Validator $formKeyValidator,
        Data $helperModule,
        SessionFactory $sessionFactory,
        RequestInterface $request,
        StoreManagerInterface $storeManager,
        ManagerInterface $messageManager,
        LoggerInterface $logger,
        MultipleWishlistRepositoryInterface $multipleWishlistRepository
    ) {
        parent::__construct(
            $resultRedirectFactory,
            $redirect,
            $formKeyValidator,
            $helperModule,
            $sessionFactory,
            $request,
            $storeManager,
            $messageManager,
            $logger
        );
        $this->multipleWishlistRepository = $multipleWishlistRepository;
    }

    public function execute(): Redirect
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        try {
            $this->init();

            if (!$this->formKeyValidator->validate($this->request)) {
                throw new LocalizedException(
                    __('Something went wrong while saving the page. Please refresh the page and try again.')
                );
            }

            $multipleWishlistParams = $this->request->getParam('multiple_wishlist');

            if (empty($multipleWishlistParams)) {
                throw new LocalizedException(
                    __('You must fill in all fields to create a new list.')
                );
            }

            $multipleWishlist = $this->updateMultipleWishlist($multipleWishlistParams);

            $this->setSuccessMessage(__(
                'List with ID %1 was updated successfully.',
                $multipleWishlist->getId()
            )->render());

            $resultRedirect->setPath('multiple_wishlist/page/view', ['id' => $multipleWishlist->getId()]);

        } catch (LocalizedException $exception) {
            $this->setErrorMessage($exception->getMessage());
            $resultRedirect->setPath('customer/account/login/');
        } catch (\Exception $exception) {
            $this->setErrorMessage($exception->getMessage());
            $resultRedirect->setPath('multiple_wishlist/page/create/');
        }

        $resultRedirect->setHttpResponseCode(301);

        return $resultRedirect;
    }

    protected function updateMultipleWishlist(array $multipleWishlistParams): MultipleWishlistInterface
    {
        $titleSanitized = htmlspecialchars($multipleWishlistParams['title']);
        $multipleWishlist = $this->multipleWishlistRepository->getById($multipleWishlistParams['id']);

        if ((int) $this->getSession()->getCustomer()->getId() !== $multipleWishlist->getCustomerId()) {
            throw new LocalizedException(__('You don\'t have access to this list.'));
        }

        $multipleWishlist->setTitle($titleSanitized);
        $multipleWishlist->setIsActive(!!$multipleWishlistParams['is_active']);

        return $this->multipleWishlistRepository->save($multipleWishlist);
    }
}
