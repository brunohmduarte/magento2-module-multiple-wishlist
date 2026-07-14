<?php

declare(strict_types= 1);

namespace BrunoDuarte\MultipleWishlist\Setup\Patch\Schema;

use BrunoDuarte\MultipleWishlist\Setup\Patch\Schema\CreateTableMultipleWishlist;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\Patch\SchemaPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

class CreateTableMultipleWishlistItem implements SchemaPatchInterface, PatchRevertableInterface
{
    public const TABLE_WISHLIST_ITEM = 'multiple_wishlist_item';

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

        $connection = $installer->getConnection();

        // Create the wishlist item table
        if (!$installer->tableExists(self::TABLE_WISHLIST_ITEM)) {
            $table = $connection->newTable(
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
                ['nullable'=> false, 'unsigned' => true],
                'Customer ID'
            )->addColumn(
                'quantity',
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Quantity items'
            )->addColumn(
                'product_id',
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Product ID'
            )->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                'Creation Time'
            )->addColumn(
                'updated_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                'Update Time'
            )->setComment(
                'Multiple Wishlist Item Table'
            );

            // Adding foreign keys
            $table->addForeignKey(
                'FK_MULTIPLE_WISHLIST_ITEM_MULTIPLE_WISHLIST',
                'wishlist_id',
                $installer->getTable(CreateTableMultipleWishlist::TABLE_WISHLIST),
                'wishlist_id',
                Table::ACTION_CASCADE
            )->addForeignKey(
                'FK_MULTIPLE_WISHLIST_ITEM_CUSTOMER_ENTITY',
                'customer_id',
                $installer->getTable('customer_entity'),
                'entity_id',
                Table::ACTION_CASCADE
            )->addForeignKey(
                'FK_MULTIPLE_WISHLIST_ITEM_CATALOG_PRODUCT_ENTITY',
                'product_id',
                $installer->getTable('catalog_product_entity'),
                'entity_id',
                Table::ACTION_CASCADE
            );

            $connection->createTable($table);
        }

        $installer->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [
            CreateTableMultipleWishlist::class
        ];
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
