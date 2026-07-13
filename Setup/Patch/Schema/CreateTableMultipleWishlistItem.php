<?php

declare(strict_types= 1);

namespace BrunoDuarte\MultipleWishlist\Setup\Patch\Schema;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\Patch\SchemaPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

class CreateTableMultipleWishlistItem implements SchemaPatchInterface, PatchRevertableInterface
{
    public const TABLE_WISHLIST_ITEM = 'multiplewishlist_item';

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(ModuleDataSetupInterface $moduleDataSetup)
    {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $installer = $this->moduleDataSetup;
        $installer->startSetup();

        // Create the wishlist item table
        if (!$installer->tableExists(self::TABLE_WISHLIST_ITEM)) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable(self::TABLE_WISHLIST_ITEM)
            )->addColumn(
                'wishlist_item_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Wishlist Item ID'
            )->addColumn(
                'wishlist_id',
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Wishlist ID'
            )->addColumn(
                'customer_id',
                Table::TYPE_INTEGER,
                null,
                ['nullable'=> true, 'default' => null],
                ''
            )->addColumn(
                '',
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                ''
            )->addColumn(
                'product_id',
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Product ID'
            )->addColumn(
                'added_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                'Added Time'
            )->setComment(
                'Multiple Wishlist Item Table'
            );

            $installer->getConnection()->createTable($table);
            $installer->endSetup();
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function revert()
    {
        $this->moduleDataSetup->getConnection()->dropTable(
            $this->moduleDataSetup->getTable(self::TABLE_WISHLIST_ITEM)
        );
    }
}
