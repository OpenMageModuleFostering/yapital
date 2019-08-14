<?php

class Codex_Yapital_Model_System_Config_Payment_Credentials_Switch
{

    const LIVE    = 1;
    const SANDBOX = 2;

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray ()
    {
        return array(
            array( 'value' => self::LIVE, 'label' => Mage::helper('yapital/data')->__('Live') ),
            array( 'value' => self::SANDBOX, 'label' => Mage::helper('yapital/data')->__('Sandbox') ),
        );
    }

    public function toArray ()
    {
        return array(
            self::LIVE    => Mage::helper('yapital/data')->__('Live'),
            self::SANDBOX => Mage::helper('yapital/data')->__('Sandbox'),
        );
    }
}