<?php
/**
 * Defines the Transaction datatype for the Yapital API
 *
 *
 * PHP version 5
 *
 *
 * @category   Datatype
 * @package    Codex_Yapital_Model_Datatype
 * @copyright  2013 Code-X GmbH
 * @link       http://code-x.de
 * @since      File available since Release 0.1.0
 */

/**
 * The Transaction type specifies the details of a transaction.
 *
 * Used by methods
 *
 * Request:
 *  - POST shops/{id}/baskets/{id}/transaction
 * Response:
 *  - GET shops/{shopId}/baskets/{basketId}/transaction
 *
 *
 * @category   Datatype
 * @package    Codex_Yapital_Model_Datatype
 * @copyright  2013 Code-X GmbH
 * @link       http://code-x.de
 * @since      Class available since Release 0.1.0
 */
class Codex_Yapital_Model_Datatype_Transaction extends Codex_Yapital_Model_Datatype_Abstract
    implements Codex_Yapital_Model_Datatype_Interface
{

    /**
     * @var Codex_Yapital_Model_Datatype_YapitalPublicId
     */
    protected $_transactionId;

    /**
     * @var string
     */
    protected $_qrCodeUrl;

    /**
     * @var Codex_Yapital_Model_Datatype_QRCodeBinary
     */
    protected $_qrCodeBin;

    /**
     * @var string
     */
    protected $_transactionStatus;

    /**
     * @var string
     */
    protected $_transactionDate;

    /**
     * @var string
     */
    protected $_orderNumber;

    /**
     * @var string
     */
    protected $_invoiceNumber;

    /**
     * @var string
     */
    protected $_returnUrl;

    /**
     * @var string
     */
    protected $_cancelUrl;

    /**
     * @var string
     */
    protected $_errorUrl;

    /**
     * @param string $cancelUrl
     */
    public function setCancelUrl ( $cancelUrl )
    {

        $this->_cancelUrl = $cancelUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getCancelUrl ()
    {

        return (string) $this->_cancelUrl;
    }

    /**
     * @param string $errorUrl
     */
    public function setErrorUrl ( $errorUrl )
    {

        $this->_errorUrl = $errorUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getErrorUrl ()
    {

        return (string) $this->_errorUrl;
    }

    /**
     * @param string $invoiceNumber
     */
    public function setInvoiceNumber ( $invoiceNumber )
    {

        $this->_invoiceNumber = $invoiceNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getInvoiceNumber ()
    {

        return (string) $this->_invoiceNumber;
    }

    /**
     * @param string $orderNumber
     */
    public function setOrderNumber ( $orderNumber )
    {

        $this->_orderNumber = $orderNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrderNumber ()
    {

        return (string) $this->_orderNumber;
    }

    /**
     * @param \Codex_Yapital_Model_Datatype_QRCodeBinary $qrCodeBin
     */
    public function setQrCodeBin ( $qrCodeBin )
    {

        $this->_qrCodeBin = $qrCodeBin;

        return $this;
    }

    /**
     * @return \Codex_Yapital_Model_Datatype_QRCodeBinary
     */
    public function getQrCodeBin ()
    {

        return $this->_qrCodeBin;
    }

    /**
     * @param string $qrCodeUrl
     */
    public function setQrCodeUrl ( $qrCodeUrl )
    {

        $this->_qrCodeUrl = $qrCodeUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getQrCodeUrl ()
    {

        return (string) $this->_qrCodeUrl;
    }

    /**
     * @param string $returnUrl
     */
    public function setReturnUrl ( $returnUrl )
    {

        $this->_returnUrl = $returnUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getReturnUrl ()
    {

        return (string) $this->_returnUrl;
    }

    /**
     * @param \Codex_Yapital_Model_Datatype_YapitalPublicId $transactionId
     */
    public function setTransactionId ( $transactionId )
    {

        $this->_transactionId = $transactionId;

        return $this;
    }

    /**
     * @return \Codex_Yapital_Model_Datatype_YapitalPublicId
     */
    public function getTransactionId ()
    {

        return $this->_transactionId;
    }

    /**
     * @param string $transactionStatus
     */
    public function setTransactionStatus ( $transactionStatus )
    {

        $this->_transactionStatus = $transactionStatus;

        return $this;
    }

    /**
     * @return \Codex_Yapital_Model_Datatype_TransactionStatus
     */
    public function getTransactionStatus ()
    {

        return $this->_transactionStatus;
    }

    /**
     * @param string $transationDate
     */
    public function setTransactionDate ( $transationDate )
    {

        $this->_transactionDate = $transationDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getTransactionDate ()
    {

        return $this->_transactionDate;
    }

    /**
     * Imports an order into this transaction
     *
     * @todo import correct?
     *
     * @param Mage_Sales_Model_Order $order
     *
     * @return Codex_Yapital_Model_Datatype_Transaction
     */
    public function importOrder ( Mage_Sales_Model_Order $order )
    {
        $this->_getConfig()->setStoreId( $order->getStoreId() );

        $this->setOrderNumber($order->getRealOrderId());
        $this->setInvoiceNumber($order->getQuoteId());

        $this->setReturnUrl( $this->_getUrl('success', $order) );
        $this->setCancelUrl( $this->_getUrl('cancel', $order) );
        $this->setErrorUrl( $this->_getUrl('error', $order) );

        return $this;
    }

    protected function _getUrl( $action, Mage_Sales_Model_Order $order )
    {
        $this->_getConfig()->setStoreId( $order->getStoreId() );

        $helper = Mage::helper('yapital');
        /* @var $helper Codex_Yapital_Helper_Data */

        return Mage::getUrl ('yapital/standard/'.$action,
                                    array(  'order_id' => $order->getId(),
                                            'secret' => $helper->getOrderHash( $order )
                                    )
                            );
    }

    function getData ()
    {
        /** @var Codex_Yapital_Model_Datatype_ISOLanguage $languageModel */
        $languageModel = Mage::getModel('yapital/datatype_ISOLanguage');

        return array(
            // "transaction_id"     => $this->getTransactionId(),
            "qr_code_url"        => $this->getQrCodeUrl(),
            // "qr_code_bin"        => $this->getQrCodeBin(),
            // "transaction_status" => $this->getTransactionStatus(),
            // "transaction_date"   => $this->getTransactionDate(),
            "order_number"       => $this->getOrderNumber(),
            "invoice_number"     => $this->getInvoiceNumber(),
            "return_url"         => $this->getReturnUrl(),
            "cancel_url"         => $this->getCancelUrl(),
            "error_url"          => $this->getErrorUrl(),
            "language"           => $languageModel->getYapitalLanguage(),
        );
    }
}
