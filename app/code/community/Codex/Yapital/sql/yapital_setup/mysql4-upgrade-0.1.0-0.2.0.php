<?php

$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Setup */

$installer->startSetup();

Mage::log('codex_yapital update to 0.2.0', null, '', true);

/**
 * Create table 'yapital/notification'
 */
$yapitalNotificationTable = $installer->getTable('yapital/notification');
$table = $installer->getConnection()
    ->newTable($yapitalNotificationTable)

    ->addColumn('entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
            array(
                'identity'  => true,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
            ),
        'Entity Id')

    ->addColumn('event_type',
    Varien_Db_Ddl_Table::TYPE_TEXT, 32, array(), 'event_type')

    ->addColumn('event_id',
    Varien_Db_Ddl_Table::TYPE_TEXT, 32, array(), 'event_id')

    ->addColumn('event_timestamp',
    Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(), 'event_timestamp')

    ->addColumn('notification_id',
        Varien_Db_Ddl_Table::TYPE_TEXT, 32, array(), 'The unique notification ID, generated by Yapital.')

    ->addColumn('transaction_id',
        Varien_Db_Ddl_Table::TYPE_TEXT, 32, array(), 'The unique transaction ID, for which the notification is sent.')

    ->addColumn('status_code',
        Varien_Db_Ddl_Table::TYPE_TEXT, 10, array(), 'The status code.')

    ->addColumn('status_information',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'The status description.')

    ->addColumn('customer_data',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'The customers name.')

    ->addColumn('amount',
        Varien_Db_Ddl_Table::TYPE_FLOAT, null, array( 'default'   => '0.0000' ), 'The payment amount.')

    ->addColumn('currency',
        Varien_Db_Ddl_Table::TYPE_TEXT, 3, array(), 'The currency used in the transaction.')

    ->addIndex('transaction_id_idx', array('transaction_id') )

    ;



$installer->getConnection()->createTable($table);
Mage::log("Yapital: Created Table $yapitalNotificationTable.", null, '', true);

$installer->endSetup();
