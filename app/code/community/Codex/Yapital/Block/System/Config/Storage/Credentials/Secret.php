<?php

class Codex_Yapital_Block_System_Config_Storage_Credentials_Secret
extends Codex_Yapital_Block_System_Config_Storage_Credentials_Abstract
{


    /*
     * Set template
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('yapital/config/credentials/secret.phtml');
    }

    /**
     * Remove scope label
     *
     * @param  Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
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
                           'id'        => $this->getConfigPath().'_notification_generate_secret_button',
                           'label'     => $this->getButtonLabel(),
                           'onclick'   => $this->getConfigPath().'_yapitalConfig.generateNotificationSecret(); return false;'
                      ));
        return $button->toHtml();
    }

    public function getButtonLabel()
    {
        return $this->helper('yapital/data')->__('Generate a new notification secret');
    }

}
