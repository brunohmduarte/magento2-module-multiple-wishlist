<?php
/**
 * @category BrunoDuarte
 * @package BrunoDuarte_MultipleWishlist
 * @copyright Copyright (c) 2026 BrunoDuarte
 */
declare(strict_types=1);

namespace BrunoDuarte\MultipleWishlist\Controller\Cart;

use Magento\Checkout\Controller\Cart as CartController;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;

/**
 * Abstract class cart controller
 *
 * @package BrunoDuarte\MultipleWishlist\Controller\Cart
 */
abstract class AbstractCart extends CartController implements ActionInterface
{
    /** @var RedirectFactory */
    protected $redirectResultFactory;

    /** @var Redirect */
    protected $redirect;

    /**
     * AbstractCart constructor.
     *
     * @param RedirectFactory $redirectFactory
     */
    public function __construct(RedirectFactory $redirectFactory)
    {
        $this->redirectResultFactory = $redirectFactory;
    }

    abstract public function execute(): Redirect;
}
