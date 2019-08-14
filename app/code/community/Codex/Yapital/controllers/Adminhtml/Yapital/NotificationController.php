<?php

class Codex_Yapital_Adminhtml_Yapital_NotificationController extends Mage_Adminhtml_Controller_Action
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
        if( $this->getRequest()->getParam('sandbox', false) )
        {
            /** @var $config Codex_Yapital_Model_Config */
            $config = Mage::getSingleton('yapital/config');
            $config->setSandbox( true );
        }
        parent::preDispatch();
    }

    public function registerAction ()
    {
        session_write_close();

        $result     = $this->_getStandardResult();

        if ( isset( $_REQUEST['notification_secret'] ) )
        {
            /** @ var $config Codex_Yapital_Model_Config */
            $config = Mage::getSingleton('yapital/config');
            $config->setStoreId(1);

            $notificationModel = $this->_getNotificationModel();

            try
            {
                $notificationModel->register();

                $result["has_errors"] = false;
                $result["message"]    = $this->_getDataHelper()->__('Notification has been registered.');

            }
            catch ( Codex_Yapital_ErrorException $e )
            {
                if ( $e->getMessage() == "Rest-Request failed: Duplicate entry found." )
                {
                    $result["has_errors"] = false;
                    $result["message"]    = $this->_getDataHelper()->__('Notification was already registered.');
                }
                else
                {
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

    public function unregisterAction()
    {
        session_write_close();

        $result     = $this->_getStandardResult();

        /** @var $notification Codex_Yapital_Model_Notification */
        $notification = Mage::getModel('yapital/notification');

        $api = Mage::getModel("yapital/api_notification");
        /* @var $api Codex_Yapital_Model_Api_Notification */

        $error_cnt = 0;
        $delete_cnt = 0;

        foreach( $notification->getRegistered() AS $_notification )
        {
            try {
                $api->delete( $_notification->getNotificationId() );
                $delete_cnt++;
            } catch( Exception $e )
            {
                $error_cnt++;
            }
        }

        if( $error_cnt )
        {
            $result['has_errors'] = true;
            $result['message'] =
                $this->__('Sorry, but your notifications could not be deleted. Please try again later or <a onclick="window.open(this.href); return false;" href="https://www.yapital.com/consumer/index.html#customersupport">contact Yapital.</a>');
        } else {
            $result['has_errors'] = false;
            $result['message'] = $this->__('%s notification(s) have been deleted.', $delete_cnt );
        }

        $result = Mage::helper('core')->jsonEncode($result);
        Mage::app()->getResponse()->setBody($result);
    }

    public function showAction()
    {
        session_write_close();

        $result     = array();

        /** @var $notification Codex_Yapital_Model_Notification */
        $notification = Mage::getModel('yapital/notification');

        $api = Mage::getModel("yapital/api_notification");
        /* @var $api Codex_Yapital_Model_Api_Notification */

        foreach( $notification->getRegistered() AS $_notification )
        {
            $result[] = $_notification->getData();
        }

        $result = Mage::helper('core')->jsonEncode($result);
        Mage::app()->getResponse()->setBody($result);
    }
}
