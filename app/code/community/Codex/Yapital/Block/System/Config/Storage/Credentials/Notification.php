<?php

class Codex_Yapital_Block_System_Config_Storage_Credentials_Notification
extends Codex_Yapital_Block_System_Config_Storage_Credentials_Abstract
{
    /*
     * Set template
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('yapital/config/credentials/notification.phtml');
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
     * Return ajax url for synchronize button
     *
     * @return string
     */
    public function getAjaxRegisterUrl()
    {
        // @todo yapital_system_config_system_storage/validate
        return Mage::getSingleton('adminhtml/url')->getUrl('*/yapital_notification/register', array( 'sandbox' => $this->is_sandbox ) );
    }

    /**
     * Return ajax url for unregister button
     *
     * @return string
     */
    public function getAjaxUnregisterUrl()
    {
        return Mage::getSingleton('adminhtml/url')->getUrl('*/yapital_notification/unregister', array( 'sandbox' => $this->is_sandbox ) );
    }

    /**
     * Return ajax url for synchronize button
     *
     * @return string
     */
    public function getAjaxStatusUpdateUrl()
    {
        // @todo yapital_system_config_system_storage/status
        return Mage::getSingleton('adminhtml/url')->getUrl('*/yapital_notification/status', array( 'sandbox' => $this->is_sandbox ) );
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
                           'id'        => $this->getConfigPath(). '_notification_button',
                           'label'     => $this->getButtonLabel(),
                           'onclick'   => $this->getConfigPath().'_yapitalConfig.register(\''.$this->getAjaxRegisterUrl().'\'); return false;'
                      ));
        return $button->toHtml();
    }

    public function getButtonLabel()
    {
        return $this->helper('yapital/data')->__('Register live notification');
    }

    public function getButtonUnregisterLabel()
    {
        return $this->helper('yapital/data')->__('Unregister all live notifications');
    }

    public function getButtonUnregisterHtml()
    {
        $button = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(array(
                'id'        => $this->getConfigPath(). '_notification_unregister_button',
                'label'     => $this->getButtonUnregisterLabel(),
                'onclick'   => $this->getConfigPath().'_yapitalConfig.unregister(\''.$this->getAjaxUnregisterUrl().'\'); return false;'
            ));
        return $button->toHtml();
    }

}
