<?php
/**
 * Webkul Software.
 *
 * @category   Webkul
 * @package    Webkul_MagicSlideShow
 * @author     Webkul Software Private Limited
 * @copyright  Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license    https://store.webkul.com/license.html
 */
namespace Webkul\MagicSlideShow\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        /*
         * Create table 'webkul_magicslideshow_images'
         */
        $table = $installer->getConnection()
            ->newTable($installer->getTable('webkul_magicslideshow_images'))
            ->addColumn(
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Image Id'
            )->addColumn(
                'title',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false, 'default' => ''],
                'Image title'
            )->addColumn(
                'filename',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false, 'default' => ''],
                'Image Name'
            )->addColumn(
                'link',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false, 'default' => ''],
                'Image Link'
            )->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['nullable' => false, 'default' => '0'],
                'Status'
            )->addColumn(
                'sort_order',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['nullable' => false, 'default' => '0'],
                'Sort Order'
            )->addColumn(
                'created_time',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => true, 'default' => null],
                'Created Time'
            )->addColumn(
                'update_time',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => true, 'default' => null],
                'Updated Time'
            )
            ->setComment('MagicSlideShow Slider Images');
        $installer->getConnection()->createTable($table);

        /**
         * Create table 'webkul_magicslideshow_group'
         */
         $table = $installer->getConnection()
         ->newTable($installer->getTable('webkul_magicslideshow_group'))
         ->addColumn(
             'id',
             \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
             11,
             ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
             'Id'
         )
         ->addColumn(
             'name',
             \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
             255,
             ['nullable' => false],
             'group name'
         )
         ->addColumn(
             'code',
             \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
             255,
             ['nullable' => false],
             'group code'
         )
         ->addColumn(
             'image_ids',
             \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
             255,
             ['nullable' => false],
             'group image_ids'
         )
         ->addColumn(
             'status',
             \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
             11,
             ['unsigned' => true, 'nullable' => false],
             'Status'
         )
         ->setComment('Slider Group Table');
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}
