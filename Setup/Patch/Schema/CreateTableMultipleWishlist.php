<?php

declare(strict_types= 1);

namespace BrunoDuarte\MultipleWishlist\Setup\Patch\Schema;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\Patch\SchemaPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

class CreateTableMultipleWishlist implements SchemaPatchInterface, PatchRevertableInterface
{
    public const TABLE_WISHLIST = 'multiple_wishlist';

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

        // Create the wishlist table
        if (!$installer->tableExists(self::TABLE_WISHLIST)) {
            // Create the wishlist table
            $table = $connection->newTable(
                $installer->getTable(self::TABLE_WISHLIST)
            )->addColumn(
                'wishlist_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Wishlist ID'
            )->addColumn(
                'customer_id',
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Customer ID'
            )->addColumn(
                'name',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Wishlist Name'
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
                'Multiple Wishlist Table'
            );

            // Adding foreign key
            $table->addForeignKey(
                'FK_MULTIPLE_WISHLIST_CUSTOMER_ENTITY',
                'customer_id',
                'customer_entity',
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
            $this->moduleDataSetup->getTable(self::TABLE_WISHLIST)
        );
    }
}
