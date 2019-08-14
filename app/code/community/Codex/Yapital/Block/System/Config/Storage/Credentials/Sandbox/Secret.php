<?php

class Codex_Yapital_Block_System_Config_Storage_Credentials_Sandbox_Secret
extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    /*
     * Set template
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('yapital/system/config/storage/credentials/sandbox/secret.phtml');
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
                           'id'        => 'notification_generate_secret_button',
                           'label'     => $this->helper('yapital/data')->__('Generate a new notification secret'),
                           'onclick'   => 'javascript:yapitalSandboxGenerateNotificationSecret(); return false;'
                      ));
        return $button->toHtml();
    }
}
