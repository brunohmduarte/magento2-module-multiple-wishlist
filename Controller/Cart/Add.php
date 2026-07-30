<?php
/**
 * @category BrunoDuarte
 * @package BrunoDuarte_MultipleWishlist
 * @copyright Copyright (c) 2026 BrunoDuarte
 */

declare(strict_types=1);

namespace BrunoDuarte\MultipleWishlist\Controller\Cart;

use BrunoDuarte\MultipleWishlist\Controller\Cart\AbstractCart;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;

class Add extends AbstractCart
{
    public function __construct(RedirectFactory $redirectResultFactory)
    {
        parent::__construct($redirectResultFactory);
    }

    public function execute(): Redirect
    {
        /**
         * @todo
         * 1. Ao adicionar os produtos no carrinho, redirecionar página para o carrinho;
         * 2. Caso dê algum erro, o redirecionamento deve ser para a página da listagem das listas;
         * 3. O controlador deve ser chamado, quando o botão de Order for clicado na listagem;
         * 4. O cliente só pode adicionar ao carrinho listas que estão ativas.
         */
        $result = $this->redirectResultFactory->create();
        return $result;
    }
}
