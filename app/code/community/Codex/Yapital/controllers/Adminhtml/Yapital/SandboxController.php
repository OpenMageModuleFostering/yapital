<?php

class Codex_Yapital_Adminhtml_Yapital_SandboxController extends Mage_Adminhtml_Controller_Action
{

    /**
     * @return Codex_Yapital_Model_Notification
     */
    protected function _getNotificationModel ()
    {
        return Mage::getModel('yapital/notification');
    }

    protected function _getDataHelper ()
    {
        return Mage::helper('yapital/data');
    }

    protected function _getStandardResult ()
    {
        return array(
            "message"    => $this->_getDataHelper()->__('We are sorry! Something went wrong.'),
            "has_errors" => true,
        );
    }

    public function preDispatch()
    {
        /** @var $config Codex_Yapital_Model_Config */
        $config = Mage::getSingleton('yapital/config');
        $config->setSandbox( true );
    }

    public function registerAction ()
    {
        session_write_close();

        $dataHelper = Mage::helper('yapital/data');
        $result     = $this->_getStandardResult();

        if ( isset( $_REQUEST['notification_secret'] ) )
        {
            $notificationModel = $this->_getNotificationModel();

            try
            {
                $notificationModel->register();

                $result["has_errors"] = false;
                $result["message"]    = $this->_getDataHelper()->__('Notification has been registered.');

            }
            catch ( Codex_Yapital_ErrorException $e )
            {
                $config = Mage::getModel('yapital/config');

                if ( $e->getMessage() == "Rest-Request failed: Duplicate entry found." )
                {
                    $result["has_errors"] = false;
                    $result["message"]    = $this->_getDataHelper()->__('Notification was already registered.');
                }
                else
                {
                    throw $e;
                    $result["message"] = $this->__("Internal error [%d]: ", $e->getCode()) . $e->getMessage();
                }
            }

        }

        $resultJSON = Mage::helper('core')->jsonEncode($result);

        $this->getResponse()->setBody($resultJSON);

    }

    public function statusAction ()
    {
        $dataHelper = Mage::helper('yapital/data');
        $result     = $this->_getStandardResult();

        $api = Mage::getModel('yapital/api_notification');
        /* @var $api Codex_Yapital_Model_Api_Notification */

        /* @var $notification Codex_Yapital_Model_Datatype_Notification */
        $tmpNotification = current($api->getAll());

        $notificationId = $tmpNotification->getNotificationId();

        if ( null !== $notificationId )
        {
            $notification = $api->get($notificationId);

            if ( $notification instanceof Codex_Yapital_Model_Datatype_Notification
                 && $notificationId == $notification->getNotificationId()
            )
            {
                $result["message"] = $dataHelper->__('Valid.');
            }
        }

        $result = Mage::helper('core')->jsonEncode($result);
        Mage::app()->getResponse()->setBody($result);
    }
}
