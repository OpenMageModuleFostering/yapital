<?php

class Codex_Yapital_Block_System_Config_Storage_Credentials_Notification
extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    /*
     * Set template
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('yapital/system/config/storage/credentials/notification.phtml');
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
        return Mage::getSingleton('adminhtml/url')->getUrl('*/yapital_notification/register');
    }

    /**
     * Return ajax url for synchronize button
     *
     * @return string
     */
    public function getAjaxStatusUpdateUrl()
    {
        // @todo yapital_system_config_system_storage/status
        return Mage::getSingleton('adminhtml/url')->getUrl('*/yapital_notification/status');
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
                           'id'        => 'notification_button',
                           'label'     => $this->helper('yapital/data')->__('Register live notification'),
                           'onclick'   => 'javascript:yapitalNotificationRegister(); return false;'
                      ));
        return $button->toHtml();
    }
}
