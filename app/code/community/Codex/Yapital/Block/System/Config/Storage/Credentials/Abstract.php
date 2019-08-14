<?php

class Codex_Yapital_Block_System_Config_Storage_Credentials_Abstract extends Mage_Adminhtml_Block_System_Config_Form_Field
{

    protected $is_sandbox = false;

    public function getConfigPath()
    {
        return ( $this->is_sandbox ? 'standard_sandbox' : 'standard') ;
    }

}