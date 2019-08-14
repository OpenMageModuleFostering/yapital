<?php

class Codex_Yapital_Block_System_Config_Storage_Credentials_Validate
extends Codex_Yapital_Block_System_Config_Storage_Credentials_Abstract
{
    protected $is_sandbox = false;

    /*
     * Set template
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('yapital/config/credentials/validate.phtml');
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
     * Return ajax url for synchronize button
     *
     * @return string
     */
    public function getAjaxValidateUpdateUrl()
    {
        // @todo yapital_system_config_system_storage/validate
        return Mage::getSingleton('adminhtml/url')->getUrl('*/yapital_config/validate', array( 'sandbox' => $this->is_sandbox ) );
    }

    /**
     * Return ajax url for synchronize button
     *
     * @return string
     */
    public function getAjaxStatusUpdateUrl()
    {
        // @todo yapital_system_config_system_storage/status
        return Mage::getSingleton('adminhtml/url')->getUrl('*/yapital_config/status', array( 'sandbox' => $this->is_sandbox ));
    }

    /**
     * Return ajax url for update button
     *
     * @return string
     */
    public function getAjaxTransactionUpdateUrl()
    {
        return Mage::getSingleton('adminhtml/url')->getUrl('*/yapital_config/update', array( 'sandbox' => $this->is_sandbox ));
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
                'id'        => $this->getConfigPath() . '_validate_button',
                'label'     => $this->getButtonLabel(),
                'onclick'   => $this->getConfigPath().'_yapitalConfig.validate(); return false;'
            ));
        return $button->toHtml();
    }

    public function getButtonLabel()
    {
        return $this->helper('yapital/data')->__('Validate live credentials');
    }

    public function getJSConfig()
    {
        return Zend_Json::encode(
            array(
                'is_sandbox' => $this->is_sandbox,
                'config_path' => $this->getConfigPath(),
                'validate_url' => $this->getAjaxValidateUpdateUrl(),
                'status_url' => $this->getAjaxStatusUpdateUrl(),
                'update_url' => $this->getAjaxTransactionUpdateUrl()
            )
        );
    }



}
