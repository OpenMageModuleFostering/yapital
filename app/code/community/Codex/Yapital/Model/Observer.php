<?php

class Codex_Yapital_Model_Observer
{
    public function aggregateYapitalReportOrderPaymentData($schedule)
    {
        Mage::app()->getLocale()->emulate(0);
        $currentDate = Mage::app()->getLocale()->date();
        $date = $currentDate->subHour(25);
        Mage::getResourceModel('yapital/report_paymentmethod')->aggregate($date);
        Mage::app()->getLocale()->revert();
        return $this;
    }
}