<?php

class Codex_Yapital_Block_Standard_Iframe extends Codex_Yapital_Block_AbstractBlock {

    protected $_order_transaction;

    public function setOrderTransaction( Codex_Yapital_Model_Order_Transaction $order_transaction ) {
        $this->_order_transaction = $order_transaction;

        $order = $this->_order_transaction->getOrder();
        $this->_getConfig()->importOrder( $order );
    }

    /**
     * @return Codex_Yapital_Model_Order_Transaction
     */
    public function getOrderTransaction() {
        return $this->_order_transaction;
    }

    public function getApiUrl() {
        return rtrim( $this->_getConfig()->getApiUrl() , '/') .'/';
    }

    public function getApiIFrameScript()
    {
        return $this->_getConfig()->getApiUrl() . $this->_getConfig()->getApiIFrameScript();
    }

    public function getTransactionId() {
        return $this->getOrderTransaction()->getTransactionId();
    }

}