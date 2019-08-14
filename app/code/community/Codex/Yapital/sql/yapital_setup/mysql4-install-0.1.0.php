<?php

$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Setup */

$installer->startSetup();

Mage::log('codex_yapital install 0.1.0', null, '', true);

/**
 * Create table 'yapital/order_transaction'
 */
$orderTransactionTable = $installer->getTable('yapital/order_transaction');
$table = $installer->getConnection()
    ->newTable($orderTransactionTable)

    ->addColumn('entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
            array(
                'identity'  => true,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
            ),
        'Entity Id')

    ->addColumn('order_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'identity'  => false,
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => false,
        ),
        'Order Id')

    ->addColumn('transaction_id',
        Varien_Db_Ddl_Table::TYPE_TEXT, 32, array(), 'Yapital Transaction Id')
    ;

$installer->getConnection()->createTable($table);
Mage::log("Yapital: Created Table $orderTransactionTable.", null, '', true);

$installer->endSetup();
