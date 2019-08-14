<?php

class Codex_Yapital_Model_Notification extends Mage_Core_Model_Abstract
{

    const YAPITAL_STATUS_PAID = 'PAID';
    const YAPITAL_STATUS_FAILED = 'FAILED';
    const YAPITAL_STATUS_CANCELLED = 'CANCELLED';

    /*
        entity_id
        notification_id
        transaction_id
        status_code
        status_information
        customer_data
        amount
        currency
     */

    /* @var Codex_Yapital_Model_Order_Transaction */
    protected $_transaction;

    protected $_eventPrefix = 'yapital_notification';

    protected $_eventObject = 'yapital_notification';

    protected function _construct()
    {
        $this->_init('yapital/notification');
    }

    /**
     * Import an array
     *
     * @param array $data
     *
     * @return Codex_Yapital_Model_Notification
     */
    public function import( Array $data )
    {
        $payment_processed_body = $data['body']['payment_processed_body'];

        $this->setData( 'notification_id',      $payment_processed_body['notification_id'] );
        $this->setData( 'transaction_id',       $payment_processed_body['transaction_id'] );
        $this->setData( 'status_code',          $payment_processed_body['status_code'] );
        $this->setData( 'status_information',   $payment_processed_body['status_information'] );
        $this->setData( 'customer_data',        $payment_processed_body['customer_data'] );
        $this->setData( 'amount',               $payment_processed_body['amount'] );
        $this->setData( 'currency',             $payment_processed_body['currency'] );

        $this->setData('event_type',        $data['event_type']);
        $this->setData('event_id',          $data['event_id']);
        $this->setData('event_timestamp',   $data['event_timestamp']);

        Codex_Yapital_Model_Log::log(
            sprintf("Processing Notification-Id #%s, Transaction-Id #%s, Magento-Order-Id %s",
                $this->getData('notification_id'),
                $this->getData('transaction_id'),
                $this->getTransaction()->getOrder()->getIncrementId()
            )
        );

        return $this;
    }

    /**
     * @return Codex_Yapital_Model_Order_Transaction
     */
    public function getTransaction()
    {
        if ( !$this->_transaction )
        {
            $this->_transaction = Mage::getModel('yapital/order_transaction');
            $this->_transaction->load($this->getTransactionId(), 'transaction_id' );
        }
        return $this->_transaction;
    }

    /**
     * Create a new notification
     *
     * @return Codex_Yapital_Model_Notification
     */
    public function register ()
    {
        Codex_Yapital_Model_Log::log("Creating new notification");

        /* @var $notification Codex_Yapital_Model_Datatype_Notification */
        $notification = Mage::getModel("yapital/datatype_notification");

        $notification->setNotificationId(""); /// @todo id
        $notification->setEventType(Codex_Yapital_Model_Datatype_EventType::PAYMENT_PROCESSED);
        $notification->setCallbackUrl( $this->getCallbackUrl() );
        $notification->setValidationStatus("UNDEFINED"); /// @todo NotificationValidationStatus
        $notification->setAcceptType("JSON"); /// @todo NotificationAcceptType as

        $api = Mage::getModel("yapital/api_notification");
        /* @var $api Codex_Yapital_Model_Api_Notification */

        $result = $api->register($notification);

        return $this;
    }

    /**
     * This method serves to get all notifications to which the shop is subscribed.
     *
     * @return Codex_Yapital_Model_Datatype_Notification[]
     */
    public function getRegistered()
    {
        /* @var $notification Codex_Yapital_Model_Datatype_Notification */
        $notification = Mage::getModel("yapital/datatype_notification");

        $api = Mage::getModel("yapital/api_notification");
        /* @var $api Codex_Yapital_Model_Api_Notification */

        return $api->getAll();
    }

    public function getCallbackUrl() {
        return Mage::getUrl('yapital/notification/receive', array('_forced_secure' => true, 'secret' => $this->getSecret() ) );
    }

    public function getSecret() {
        return $this->_getConfig()->getNotificationSecret();
    }

    public function processOrder()
    {
        $_order = $this->getTransaction()->getOrder();

        switch ( $this->getStatusCode()  ) {

            case self::YAPITAL_STATUS_PAID:
                $this->_processOrderPaid();
                break;

            case self::YAPITAL_STATUS_FAILED:
                $this->_processOrderFailed();
                break;

            case self::YAPITAL_STATUS_CANCELLED:
                $this->_processOrderCancelled();
                break;

        }

        return $this;
    }

    protected function _processOrderPaid()
    {
        /** @var $order Mage_Sales_Model_Order */
        $order        = $this->getTransaction()->getOrder();
        $payment      = $order->getPayment();
        $translations = Mage::helper('yapital');

        // TODO: Validate amount and currency
        $config = $this->_getConfig();
        $config->importOrder($this->getTransaction()->getOrder());

        $order->setState($this->_getConfig()->getOrderPaidState(), true, $translations->__('Order paid'), false);

        $this->_createInvoice();
        $order->getPayment()->setLastTransId( $this->getTransaction()->getId() );

        $this->_closeTransaction();

        $order->save();

        return $this;
    }

    /**
     * Builds invoice for order
     */
    protected function _createInvoice()
    {
        /** @var $order Mage_Sales_Model_Order */
        $order = $this->getTransaction()->getOrder();

        if (!$order->canInvoice()) {
            return null;
        }

        /** @var $invoice Mage_Sales_Model_Order_Invoice */
        $invoice = $order->prepareInvoice();

        $invoice->register()->capture();
        $order->addRelatedObject($invoice);

        return $this;
    }

    protected function _processOrderCancelled()
    {

        $translations = Mage::helper('yapital');

        $order = $this->getTransaction()->getOrder();
        $order->registerCancellation($translations->__('Order cancelled'),false);

        $this->_closeTransaction();

        $order->save();

        return $this;
    }

    protected function _processOrderFailed()
    {
        $order = $this->getTransaction()->getOrder();
        $order->registerCancellation('',false);

        $this->_closeTransaction();

        $order->save();

        return $this;
    }

    protected function _closeTransaction() {
        $this->getTransaction()->close();
        return $this;
    }

    /**
     * Gets the Config model
     *
     * @return \Codex_Yapital_Model_Config
     */
    protected function _getConfig() {

        /* @var $config  Codex_Yapital_Model_Config */
        $config = Mage::getSingleton('yapital/config');

        return $config;
    }

}
