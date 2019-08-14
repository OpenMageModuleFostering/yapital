<?php

class Codex_Yapital_Model_Api_Basket_Transaction extends Codex_Yapital_Model_Api_Abstract
{

    /* @var Codex_Yapital_Model_Order_Transaction */
    protected $_orderTransaction;

    /**
     * Submit the BasketsTransaction
     *
     * @return Codex_Yapital_Model_Datatype_Shoprestresponse
     */
    public function sendOrder ( Mage_Sales_Model_Order $order )
    {
        Codex_Yapital_Model_Log::log("Sending BasketTransaction");

        /* @var $basketTransaction Codex_Yapital_Model_DataType_BasketsTransaction */
        $basketTransaction = Mage::getModel('yapital/datatype_basketstransaction');
        $basketTransaction->importOrder($order);


        $url      = '/shops/' . $this->_getConfig()->getYapitalShopId() . '/basket_transaction';
        $response = $this->_send($url, $basketTransaction);

        /**
         * @var $shopRestResponse Codex_Yapital_Model_Datatype_Shoprestresponse
         */
        $shopRestResponse = Mage::getModel("yapital/datatype_shoprestresponse");
        $shopRestResponse->importRawResponse($response);

        $order_transaction = $this->getOrderTransaction();
        $order_transaction->importShopRestResponse($order, $shopRestResponse);

        $order_transaction->save();

        return $shopRestResponse;
    }

    /**
     * @return Codex_Yapital_Model_Order_Transaction
     */
    public function getOrderTransaction ()
    {
        if ( !$this->_orderTransaction )
        {
            $this->_orderTransaction = Mage::getModel("yapital/order_transaction");
        }

        return $this->_orderTransaction;
    }

}
