<?php

class Codex_Yapital_Model_Resource_Order_Transaction extends Mage_Core_Model_Mysql4_Abstract
{

    protected function _construct()
    {
        $this->_init('yapital/order_transaction', 'entity_id');
    }

}