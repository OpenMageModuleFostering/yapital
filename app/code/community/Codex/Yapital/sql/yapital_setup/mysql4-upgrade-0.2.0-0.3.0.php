<?php

/** @var $installer Mage_Sales_Model_Entity_Setup */
$installer = $this;
$installer->startSetup();

Codex_Yapital_Model_Log::log('codex_yapital update to 0.3.0', null, '', true);

/**
* Create table 'sales/order_aggregated_payment'
*/
$orderAggregatedPaymentTable = $installer->getTable('sales/order_aggregated_payment');
$table = $installer->getConnection()
    ->newTable($orderAggregatedPaymentTable)
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true
    ), 'Id')
    ->addColumn('period', Varien_Db_Ddl_Table::TYPE_DATE, null, array(), 'Period')
    ->addColumn('method', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Method')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true
    ), 'Store Id')
    ->addColumn('order_status', Varien_Db_Ddl_Table::TYPE_TEXT, 50, array(
        'nullable'  => false,
        'default'   => ''
    ), 'Order Status')
    ->addColumn('orders_count', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'default'   => '0'
    ), 'Orders Count')
    ->addColumn('total_qty_ordered', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'nullable'  => false,
        'default'   => '0.0000'
    ), 'Total Qty Ordered')
    ->addColumn('total_qty_invoiced', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'nullable'  => false,
        'default'   => '0.0000'
    ), 'Total Qty Invoiced')
    ->addColumn('total_income_amount', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'nullable'  => false,
        'default'   => '0.0000',
    ), 'Total Income Amount')
    ->addColumn('total_revenue_amount', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'nullable'  => false,
        'default'   => '0.0000'
    ), 'Total Revenue Amount')
    ->addColumn('total_profit_amount', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'nullable'  => false,
        'default'   => '0.0000'
    ), 'Total Profit Amount')
    ->addColumn('total_invoiced_amount', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'nullable'  => false,
        'default'   => '0.0000'
    ), 'Total Invoiced Amount')
    ->addColumn('total_canceled_amount', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'nullable'  => false,
        'default'   => '0.0000'
    ), 'Total Canceled Amount')
    ->addColumn('total_paid_amount', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'nullable'  => false,
        'default'   => '0.0000'
    ), 'Total Paid Amount')
    ->addColumn('total_refunded_amount', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'nullable'  => false,
        'default'   => '0.0000'
    ), 'Total Refunded Amount')
    ->addColumn('total_tax_amount', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'nullable'  => false,
        'default'   => '0.0000'
    ), 'Total Tax Amount')
    ->addColumn('total_tax_amount_actual', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'nullable'  => false,
        'default'   => '0.0000'
    ), 'Total Tax Amount Actual')
    ->addColumn('total_shipping_amount', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'nullable'  => false,
        'default'   => '0.0000'
    ), 'Total Shipping Amount')
    ->addColumn('total_shipping_amount_actual', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'nullable'  => false,
        'default'   => '0.0000'
    ), 'Total Shipping Amount Actual')
    ->addColumn('total_discount_amount', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'nullable'  => false,
        'default'   => '0.0000'
    ), 'Total Discount Amount')
    ->addColumn('total_discount_amount_actual', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'nullable'  => false,
        'default'   => '0.0000'
    ), 'Total Discount Amount Actual')
    ->addIndex(
        $installer->getIdxName(
            'sales/order_aggregated_payment',
            array('period', 'method', 'store_id', 'order_status'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        array('period', 'method', 'store_id', 'order_status'), array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE)
    )
    ->addIndex(
        $installer->getIdxName('sales/order_aggregated_payment', array('store_id')),
        array('store_id')
    )
    ->addForeignKey(
        $installer->getFkName('sales/order_aggregated_payment', 'store_id', 'core/store', 'store_id'),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_SET_NULL, Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->setComment('Sales Order Aggregated Payment');

$installer->getConnection()->createTable($table);
Mage::log("Yapital: Created Table $orderAggregatedPaymentTable.", null, '', true);

$installer->endSetup();
