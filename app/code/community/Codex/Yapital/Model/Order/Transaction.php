<?php

/**
 * Class Codex_Yapital_Model_Order_Transaction.
 *
 * @category   Yapital
 *
 * @method void setOrderId(int $id) Set the order id
 * @method void setTransactionId(int $id) Set the order id
 */
class Codex_Yapital_Model_Order_Transaction extends Mage_Core_Model_Abstract
{

    protected $_eventPrefix = 'yapital_order_transaction';

    protected $_eventObject = 'yapital_order_transaction';

    /* @var Mage_Sales_Model_Order */
    protected $_order;

    protected function _construct()
    {
        $this->_init('yapital/order_transaction');
    }

    public function importShopRestResponse( Mage_Sales_Model_Order $order, Codex_Yapital_Model_Datatype_Shoprestresponse $response)
    {
        $this->setOrderId( $order->getId() );
        $this->setTransactionId( $response->getPayload()->transaction_id );

        return $this;
    }

    /*
     * @return Mage_Sales_Model_Order
     */
    public function getOrder() {

        if ( !$this->_order ) {
            $this->_order = Mage::getModel('sales/order');
            $this->_order->load( $this->getOrderId() );
        }
        return $this->_order;
    }

    protected function _afterSave()
    {
        $order = $this->getOrder();
        $payment = $order->getPayment();

        $payment->setTransactionId( $this->getTransactionId() );
        $transaction = $payment->addTransaction(Mage_Sales_Model_Order_Payment_Transaction::TYPE_ORDER, null, false, "Yapital-Payment-Auth");

        $transaction->setIsClosed(0);

        $order->save();

        return parent::_afterSave();
    }

    public function close() {
        $payment = $this->getOrder()->getPayment();
        $transaction = $payment->getTransaction( $this->getTransactionId() );
        if ( $transaction ) {
            $transaction->setIsClosed(1);
            $transaction->save();
        }
        return $this;
    }


}
