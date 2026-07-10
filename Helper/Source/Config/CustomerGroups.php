<?php

declare(strict_types=1);

namespace BrunoDuarte\MultipleWishlist\Helper\Source\Config;

use Magento\Customer\Model\ResourceModel\Group\CollectionFactory as CustomerGroupCollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;

class CustomerGroups implements OptionSourceInterface
{
    private CustomerGroupCollectionFactory $customerGroupCollectionFactory;

    public function __construct(
        CustomerGroupCollectionFactory $customerGroupCollectionFactory
    ) {
        $this->customerGroupCollectionFactory = $customerGroupCollectionFactory;
    }

    public function toOptionArray(): array
    {
        $customerGroupCollection = $this->customerGroupCollectionFactory->create()->toOptionArray();
        unset($customerGroupCollection[0]);
        return $customerGroupCollection;
    }
}
