<?php

class Codex_Yapital_StandardController extends Mage_Core_Controller_Front_Action
{

    /* @var $_order Mage_Sales_Model_Order */
    protected $_order;

    /**
     * @return Mage_Checkout_Model_Session
     */
    protected function _getSession()
    {
        return Mage::getSingleton('checkout/session');
    }

    /**
     *  Get order
     *
     * @return      Mage_Sales_Model_Order
     */
    protected function _getOrder()
    {
        if ( !$this->_order )
        {
            $order_id = $this->getRequest()->getParam('order_id');
            $secret = $this->getRequest()->getParam('secret');

            $this->_order = Mage::getModel('sales/order')->load( $order_id );
            if ( $this->_order->getId() ) {

                $helper = Mage::helper('yapital');
                /* @var $helper Codex_Yapital_Helper_Data */

                if ( $secret != $helper->getOrderHash($this->_order) || empty($secret) ) {
                    Codex_Yapital_Model_Log::error("access to order $order_id denied");
                    $this->_forward('accessdenied');
                    $this->_order->reset();
                }

            }

        }
        return $this->_order;
    }

    public function accessdeniedAction() {
        $this->_response->clearHeader('Location');  // no redirect to basket

        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * When a customer cancel payment from yapital.
     */
    public function cancelAction()
    {
        if ( $order = $this->_getOrder() ) {
            if ($order->getId()) {
                $order->addStatusHistoryComment('Customer canceled order at yapital');
                $order->cancel()->save();
            }
        }

        Mage::helper('yapital/checkout')->restoreQuote();

        $this->_redirect('checkout/cart');
    }

    /**
     * when yapital-customer returns
     */
    public function successAction()
    {
        Mage::getSingleton('checkout/session')->getQuote()->setIsActive(false)->save();

        try {
            $this->_getOrder()->sendNewOrderEmail();
        } catch (Exception $e) {
            Mage::logException($e);
        }

        $this->_redirect('checkout/onepage/success', array('_secure'=>true));
    }

    /**
     * wenn yapital-customer got an error
     */
    public function errorAction ()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * wenn yapital-customer got an error
     */
    public function documentationAction ()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * when customer checkout using yapital payment method
     */
    public function redirectAction()
    {
        $order = Mage::getModel('sales/order');
        /* @var $order Mage_Sales_Model_Order */

        $order_id = $this->getRequest()->getParam('order_id');
        if ( !$order_id ) {
            $order_id = $this->_getSession()->getLastOrderId();
        }

        $order->load( $order_id );

        if ( $order->getId() ) {

            $api = Mage::getModel('yapital/api_basket_transaction');
            /* @var $api Codex_Yapital_Model_Api_Basket_Transaction */

            try {
                $response = $api->sendOrder( $order );
                $order_transaction = $api->getOrderTransaction();

                $this->loadLayout();
                if ( $iframe_block = $this->getLayout()->getBlock('yapital.standard.iframe') ) {
                    /* @var $iframe_block Codex_Yapital_Block_Standard_Iframe */
                    $iframe_block->setOrderTransaction( $order_transaction );
                }
                $this->renderLayout();

            } catch ( Exception $e ) {
                $order = $this->_getOrder();
                $order->addStatusHistoryComment( $e->getMessage() );
                Codex_Yapital_Model_Log::error( $e->getMessage() );
                $this->_forward('error');
            }

        } else {

            $this->_forward('accessdenied');

        }

    }

}
