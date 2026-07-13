<?php

declare(strict_types= 1);

namespace BrunoDuarte\MultipleWishlist\Setup\Patch\Schema;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\Patch\SchemaPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

class CreateTableMultipleWishlist implements SchemaPatchInterface, PatchRevertableInterface
{
    public const TABLE_WISHLIST = 'multiplewishlist';

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

        // Create the wishlist table
        if (!$installer->tableExists(self::TABLE_WISHLIST)) {
            // Create the wishlist table
            $table = $installer->getConnection()->newTable(
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
            )->setComment(
                'Multiple Wishlist Table'
            );
            $installer->getConnection()->createTable($table);
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
            $this->moduleDataSetup->getTable(self::TABLE_WISHLIST)
        );
    }
}
