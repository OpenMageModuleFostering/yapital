<?php

class Codex_Yapital_Model_Resource_Notification extends Mage_Core_Model_Mysql4_Abstract
{

    protected function _construct ()
    {
        $this->_init('yapital/notification', 'entity_id');
    }

}