<?php

class Codex_Yapital_Block_System_Config_Storage_Credentials_Sandbox_Notification
extends Codex_Yapital_Block_System_Config_Storage_Credentials_Notification
{
    protected $is_sandbox = true;

    public function getButtonLabel()
    {
        return $this->helper('yapital/data')->__('Register sandbox notification');
    }

    public function getButtonUnregisterLabel()
    {
        return $this->helper('yapital/data')->__('Unregister all sandbox notifications');
    }

}
