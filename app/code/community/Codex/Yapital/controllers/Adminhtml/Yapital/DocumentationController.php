<?php

class Codex_Yapital_Adminhtml_Yapital_DocumentationController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Add report/sales breadcrumbs
     *
     * @return Mage_Adminhtml_Report_SalesController
     */
    public function _initAction()
    {
        parent::_initAction();
        $helper = Mage::helper('yapital');
        $this->_addBreadcrumb($helper->__('Yapital'), $helper->__('Yapital'));
        return $this;
    }

    public function mainAction()
    {
        echo "foo";
    }

    protected function _isAllowed()
    {
        switch ($this->getRequest()->getActionName()) {
            case 'payment':
                return $this->_getSession()->isAllowed('report/yapital/payment');
                break;
            default:
                return $this->_getSession()->isAllowed('report/yapital');
                break;
        }
    }
}
