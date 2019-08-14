<?php

class Codex_Yapital_Block_System_Config_Storage_Credentials_Update
extends Codex_Yapital_Block_System_Config_Storage_Credentials_Abstract
{
    protected $_template = 'yapital/config/credentials/update.phtml';


    public function getButtonLabel()
    {
        return $this->helper('yapital/data')->__('Update orders');
    }

    /**
     * Return element html
     *
     * @param  Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        return $this->_toHtml();
    }

    /**
     * Generate synchronize button html
     *
     * @return string
     */
    public function getButtonHtml()
    {
        $button = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(array(
                'id'        => 'validate_button',
                'label'     => $this->getButtonLabel(),
                'onclick'   => $this->getConfigPath().'_yapitalConfig.updateTransactions(); return false;'
            ));
        return $button->toHtml();
    }
}
