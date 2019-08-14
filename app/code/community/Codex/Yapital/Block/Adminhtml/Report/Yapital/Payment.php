<?php

class Codex_Yapital_Block_Adminhtml_Report_Yapital_Payment extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'yapital';
        $this->_controller = 'adminhtml_report_yapital_payment';
        $this->_headerText = Mage::helper('yapital')->__('Yapital Payment Method Report');
        parent::__construct();
        $this->setTemplate('report/grid/container.phtml');
        $this->_removeButton('add');
        $this->addButton('filter_form_submit', array(
            'label'     => Mage::helper('yapital')->__('Show Report'),
            'onclick'   => 'filterFormSubmit()'
        ));
    }

    public function getFilterUrl()
    {
        $this->getRequest()->setParam('filter', null);
        return $this->getUrl('*/*/payment', array('_current' => true));
    }
}
