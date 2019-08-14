<?php

class Codex_Yapital_Block_System_Config_Storage_Credentials_Sandbox_Update
extends Codex_Yapital_Block_System_Config_Storage_Credentials_Update
{
    protected $is_sandbox = true;

    public function getButtonLabel()
    {
        return $this->helper('yapital/data')->__('Update sandbox orders');
    }

}
