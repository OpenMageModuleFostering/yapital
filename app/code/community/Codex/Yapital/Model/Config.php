<?php

class Codex_Yapital_Model_Config
{

    protected $_storeId = null;
    protected $_force_sandbox = false;

    /**
     * Helps forcing Sandbox Settings
     * @param $bool
     */
    public function setSandbox( $bool )
    {
        $this->_force_sandbox = $bool;
    }

    /**
     * Get the IFrame Script
     *
     * This script is used at the end of the payment process.
     * After checkout.
     *
     * @return Mage_Core_Model_Config_Element
     */
    public function getApiIFrameScript()
    {
        if ($this->getCredentialsSwitch() == Codex_Yapital_Model_System_Config_Payment_Credentials_Switch::SANDBOX)
        {
            // sandbox
            return Mage::getConfig()->getNode('default/yapital_sandbox/url/iframe_script');
        } else {
            // live
            return Mage::getConfig()->getNode('default/yapital/url/iframe_script');
        }
    }


    /**
     * Get the base URL of the api
     *
     * @return Mage_Core_Model_Config_Element
     */
    public function getApiUrl()
    {
        if ($this->getCredentialsSwitch() == Codex_Yapital_Model_System_Config_Payment_Credentials_Switch::SANDBOX)
        {
            // sandbox
            return Mage::getConfig()->getNode('default/yapital_sandbox/url/base');
        } else {
            // live
            return Mage::getConfig()->getNode('default/yapital/url/base');
        }
    }


    public function getApiClientId()
    {
        if ($this->getCredentialsSwitch() == Codex_Yapital_Model_System_Config_Payment_Credentials_Switch::SANDBOX)
        { // sandbox is selected: return sandbox setting
            $clientId = Mage::getStoreConfig('payment/yapital_standard/sandbox_client_id', $this->getStoreId());
        }
        else
        { // default: live
            $clientId = Mage::getStoreConfig('payment/yapital_standard/client_id', $this->getStoreId());
        }

        return $clientId;
    }


    public function getApiSecret()
    {
        if ($this->getCredentialsSwitch() == Codex_Yapital_Model_System_Config_Payment_Credentials_Switch::SANDBOX)
        { // sandbox is selected: return sandbox setting
            $apiSecret = Mage::getStoreConfig('payment/yapital_standard/sandbox_secret_key', $this->getStoreId());
        }
        else
        { // default: live
            $apiSecret = Mage::getStoreConfig('payment/yapital_standard/secret_key', $this->getStoreId());
        }

        return $apiSecret;
    }


    /**
     * Get the path to the api
     *
     * @return Mage_Core_Model_Config_Element
     */
    public function getApiUrlPath()
    {
        if ($this->getCredentialsSwitch() == Codex_Yapital_Model_System_Config_Payment_Credentials_Switch::SANDBOX)
        {
            // sandbox
            return Mage::getConfig()->getNode('default/yapital_sandbox/url/api');
        } else {
            // live
            return Mage::getConfig()->getNode('default/yapital/url/api');
        }
    }


    public function getCredentialsSwitch()
    {
        if( $this->_force_sandbox )
        {
            return Codex_Yapital_Model_System_Config_Payment_Credentials_Switch::SANDBOX;
        }
        return Mage::getStoreConfig('payment/yapital_standard/credentials_switch', $this->getStoreId());
    }


    public function getNotificationSecret()
    {
        if ($this->getCredentialsSwitch() == Codex_Yapital_Model_System_Config_Payment_Credentials_Switch::SANDBOX)
        { // sandbox is selected: return sandbox setting
            $notificationSecret = Mage::getStoreConfig(
                'payment/yapital_standard/sandbox_notification_secret',
                $this->getStoreId()
            );
        }
        else
        {
            $notificationSecret = Mage::getStoreConfig(
                'payment/yapital_standard/notification_secret',
                $this->getStoreId()
            );
        }

        return $notificationSecret;
    }


    public function getOrderPaidState()
    {
        return Mage::getStoreConfig('payment/yapital_standard/order_status', $this->getStoreId());
    }


    public function getStoreId()
    {
        if (null === $this->_storeId)
        {
            $this->_storeId = Mage::app()->getStore()->getStoreId();
        }

        return $this->_storeId;
    }


    public function getYapitalShopId()
    {
        if ($this->getCredentialsSwitch() == Codex_Yapital_Model_System_Config_Payment_Credentials_Switch::SANDBOX)
        { // sandbox is selected: use sandbox setting
            $shopId = Mage::getStoreConfig('payment/yapital_standard/sandbox_shop_id', $this->getStoreId());
        }
        else
        { // default: live
            $shopId = Mage::getStoreConfig('payment/yapital_standard/shop_id', $this->getStoreId());
        }

        return $shopId;
    }


    public function importOrder(Mage_Sales_Model_Order $order)
    {
        $this->setStoreId($order->getStoreId());
    }


    public function setStoreId($store_id)
    {
        $this->_storeId = $store_id;
        return $this;
    }
}
