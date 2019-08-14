<?php

class Codex_Yapital_Model_Payment_Standard extends Mage_Payment_Model_Method_Abstract
{
    /**
     * unique internal payment method identifier
     *
     * @var string [a-z0-9_]
     */
    protected $_code = 'yapital_standard';

    protected $_isGateway                   = false;
    protected $_canOrder                    = false;
    protected $_canAuthorize                = false;
    protected $_canCapture                  = true;
    protected $_canCapturePartial           = false;
    protected $_canRefund                   = true;
    protected $_canRefundInvoicePartial     = true;
    protected $_canVoid                     = false;
    protected $_canUseInternal              = true;
    protected $_canUseCheckout              = true;
    protected $_canUseForMultishipping      = false;
    protected $_isInitializeNeeded          = true;
    protected $_canFetchTransactionInfo     = false;
    protected $_canReviewPayment            = false;
    protected $_canCreateBillingAgreement   = false;
    protected $_canManageRecurringProfiles  = true;
    protected $_canCancelInvoice            = false;

    public function initialize($paymentAction, $stateObject)
    {
        $state = Mage_Sales_Model_Order::STATE_PENDING_PAYMENT;
        $stateObject->setState($state);
        $stateObject->setStatus('pending_payment');
        $stateObject->setIsNotified(false);
    }

    public function getOrderPlaceRedirectUrl()
    {
        return Mage::getUrl('yapital/standard/redirect', array('_secure' => true));
    }


    public function refund(Varien_Object $payment, $amount)
    {
        /** @var $payment Mage_Sales_Model_Order_Payment */

        /* @var $api Codex_Yapital_Model_Api_ReturnBasket */
        $api = Mage::getModel('yapital/api_returnBasket');

        /** @var Codex_Yapital_Model_Datatype_Returnbasket $basket */
        $basket = Mage::getModel('yapital/datatype_returnbasket');

        /* @var $amount Codex_Yapital_Model_Datatype_Amount */
        $amountModel = Mage::getModel('yapital/datatype_amount');

        $amountModel->setCurrency(Codex_Yapital_Model_Datatype_Currency::EUR);
        $amountModel->setValue($amount);

        $basket->setAmountToCredit($amountModel);

        /** @var $config Codex_Yapital_Model_Config */
        $config = Mage::getSingleton('yapital/config');
        $config->importOrder( $payment->getOrder() );

        $response = $api->send($config->getYapitalShopId(), $payment->getAuthorizationTransaction()->getTxnId(), $basket);
        Codex_Yapital_Model_Log::log("ReturnBasket-Response:". $response);

        if (!$api->getClient()->getHttpClient()->getLastResponse()->isSuccessful())
        {
            throw new Exception('could not process refund');
        }

        return $this;
    }
}
