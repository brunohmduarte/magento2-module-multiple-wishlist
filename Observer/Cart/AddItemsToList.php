<?php

declare(strict_types=1);

namespace BrunoDuarte\MultipleWishlist\Observer\Cart;

// use BrunoDuarte\MultipleWishlist\Api\MultipleWishlistItemRepositoryInterface;
use BrunoDuarte\MultipleWishlist\Api\Data\MultipleWishlistInterface;
use BrunoDuarte\MultipleWishlist\Model\MultipleWishlistItem;
use BrunoDuarte\MultipleWishlist\Model\MultipleWishlistItemFactory;
use BrunoDuarte\MultipleWishlist\Model\MultipleWishlistItemRepository;
use BrunoDuarte\MultipleWishlist\Helper\Data as HelperModule;
use Magento\Framework\Event\Observer;
use Magento\Framework\Message\ManagerInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Model\Quote\Item;
use Psr\Log\LoggerInterface;

class AddItemsToList implements \Magento\Framework\Event\ObserverInterface
{
    private MultipleWishlistItemRepository $multipleWishlistItemRepository;
    private MultipleWishlistItemFactory $multipleWishlistItemFactory;
    private HelperModule $helperModule;
    private ManagerInterface $messageManager;
    private LoggerInterface $logger;

    public function __construct(
        MultipleWishlistItemRepository $multipleWishlistItemRepository,
        MultipleWishlistItemFactory $multipleWishlistItemFactory,
        HelperModule $helperModule,
        ManagerInterface $messageManager,
        LoggerInterface $logger
    ) {
        $this->multipleWishlistItemRepository = $multipleWishlistItemRepository;
        $this->multipleWishlistItemFactory = $multipleWishlistItemFactory;
        $this->helperModule = $helperModule;
        $this->messageManager = $messageManager;
        $this->logger = $logger;
    }

    public function execute(Observer $observer): void
    {
        $counter = 1;
        /** @var CartInterface $quote */
        $quote = $observer->getData('quote');

        /** @var MultipleWishlistInterface $multipleWishlist */
        $multipleWishlist = $observer->getData('multipleWishlist');

        /** @var Item $item */
        foreach ($quote->getItems() as $item) {
            if ($this->helperModule->getMaxQtyItemsByList() !== 0) {
                if ($counter > $this->helperModule->getMaxQtyItemsByList()) {
                    $this->messageManager->addWarningMessage(__(
                        'The maximum quantity of items by list is %1. The first %2 items have been added.',
                        $this->helperModule->getMaxQtyItemsByList(),
                        ($counter - 1)
                    )->render());
                    return;
                }
            }

            /** @var MultipleWishlistItem $multipleWishlistItem */
            $multipleWishlistItem = $this->multipleWishlistItemFactory->create();

            $multipleWishlistItem->setProductId($item->getProduct()->getId())
                ->setQty($item->getQty())
                ->setWishlistId($multipleWishlist->getId());

            $multipleWishlistItem = $this->multipleWishlistItemRepository->save($multipleWishlistItem);

            $successMessage = __(
                'Created item with ID %1 to wishlist with %2',
                $multipleWishlistItem->getId(),
                $multipleWishlist->getId()
            )->render();

            $this->logger->info($successMessage);
            $this->messageManager->addSuccessMessage($successMessage);

            $counter++;
        }
    }
}
