<?php

class Codex_Yapital_Block_System_Config_Storage_Credentials_Sandbox_Validate
extends Codex_Yapital_Block_System_Config_Storage_Credentials_Validate
{

    protected $is_sandbox = true;

    public function getButtonLabel()
    {
        return $this->helper('yapital/data')->__('Validate sandbox credentials');
    }

}
