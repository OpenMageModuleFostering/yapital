<?php

class Codex_Yapital_Model_Resource_Notification_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{

    public function _construct()
    {
        $this->_init('yapital/notification');
    }

}