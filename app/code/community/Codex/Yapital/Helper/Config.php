<?php

class Codex_Yapital_Helper_Config extends Mage_Core_Helper_Abstract
{
    public function getConfigModel()
    {
        return Mage::getSingleton('yapital/config');
    }
}
