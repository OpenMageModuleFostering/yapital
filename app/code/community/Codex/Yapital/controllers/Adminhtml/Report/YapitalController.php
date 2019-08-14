<?php

class Codex_Yapital_Adminhtml_Report_YapitalController extends Mage_Adminhtml_Controller_Report_Abstract
{
    /**
     * Add report/sales breadcrumbs
     *
     * @return Mage_Adminhtml_Report_SalesController
     */
    public function _initAction()
    {
        parent::_initAction();
        $this->_addBreadcrumb(Mage::helper('yapital')->__('Yapital'), Mage::helper('yapital')->__('Yapital'));
        return $this;
    }

    /**
     * Retrieve array of collection names by code specified in request
     *
     * @deprecated after 1.4.0.1
     * @return array
     */
    protected function _getCollectionNames()
    {
        return array();
    }

    /**
     * Refresh statistics for last 25 hours
     *
     * @deprecated after 1.4.0.1
     * @return Mage_Adminhtml_Report_SalesController
     */
    public function refreshRecentAction()
    {
        return $this->_forward('refreshRecent', 'report_statistics');
    }

    /**
     * Refresh statistics for all period
     *
     * @deprecated after 1.4.0.1
     * @return Mage_Adminhtml_Report_SalesController
     */
    public function refreshLifetimeAction()
    {
        try {
            Mage::getResourceModel('yapital/report_paymentmethod')->aggregate(null, null);
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Lifetime statistics have been updated.'));
        } catch (Mage_Core_Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Unable to refresh lifetime statistics.'));
            Mage::logException($e);
        }
    }

    public function paymentAction()
    {
        $this->_title($this->__('Reports'))->_title($this->__('Yapital'))->_title($this->__('Payment'));

        //$this->_showLastExecutionTime(Mage_Reports_Model_Flag::REPORT_SHIPPING_FLAG_CODE, 'shipping');

        $this->_initAction()
            ->_setActiveMenu('report/yapital/payment')
            ->_addBreadcrumb(Mage::helper('yapital')->__('Payment'), Mage::helper('yapital')->__('Payment'));

        $gridBlock = $this->getLayout()->getBlock('adminhtml_report_yapital_payment.grid');
        $filterFormBlock = $this->getLayout()->getBlock('grid.filter.form');

        $this->_initReportAction(array(
            $gridBlock,
            $filterFormBlock
        ));

        $this->renderLayout();
    }

    /**
     * Export payment report grid to CSV format
     */
    public function exportPaymentCsvAction()
    {
        $fileName   = 'payment.csv';
        $grid       = $this->getLayout()->createBlock('yapital/adminhtml_report_yapital_payment_grid');
        $this->_initReportAction($grid);
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    /**
     * Export payment report grid to Excel XML format
     */
    public function exportPaymentExcelAction()
    {
        $fileName   = 'payment.xml';
        $grid       = $this->getLayout()->createBlock('yapital/adminhtml_report_yapital_payment_grid');
        $this->_initReportAction($grid);
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }

    /**
     * @deprecated after 1.4.0.1
     */
    public function refreshStatisticsAction()
    {
        return $this->_forward('index', 'report_statistics');
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