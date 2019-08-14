<?php

class Codex_Yapital_Helper_Data extends Mage_Core_Helper_Abstract
{

    public function getOrderHash( Mage_Sales_Model_Order $order )
    {
        return md5( $order->getId() . $this->_getConfig()->getNotificationSecret() );
    }

    /**
     * Gets the Config model
     *
     * @return \Codex_Yapital_Model_Config
     */
    protected function _getConfig() {
        return Mage::getSingleton('yapital/config');
    }

}