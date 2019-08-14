<?php

class Codex_Yapital_NotificationController extends Mage_Core_Controller_Front_Action {

    public function receiveAction()
    {
        Codex_Yapital_Model_Log::log("notification: processing");
        Codex_Yapital_Model_Log::debug(
	        sprintf(
		        "<<<REQUEST\n%s\nREQUEST;",
		        $this->getRequest()->getRawBody()
	        )
        );


        $notification = Mage::getModel('yapital/notification');
        /* @var $notification Codex_Yapital_Model_Notification */

        $json = $this->getRequest()->getRawBody();
        if ( $this->getRequest()->getParam('debug_json') != '' ) {
            $json = $this->getRequest()->getParam('debug_json');
        }

        $data = json_decode( $json , true );
        if ( is_array( $data ) ) {
            $notification->import( $data );

            $notificationPrefix = "notification";

            if ($notification->getId())
            {
                $notificationPrefix .= " (" . $notification->getId() . ")";
            }

            $notificationPrefix .= ": ";

            if ( $notification->getSecret() != '' && $notification->getSecret() == $this->getRequest()->getParam('secret') )
            {
                try {
                    $notification->save();
                    $notification->processOrder();
                    Codex_Yapital_Model_Log::log($notificationPrefix . "success");
                    $this->getResponse()->setHttpResponseCode(200); // OK
                } catch ( Exception $e ) {
                    Codex_Yapital_Model_Log::error($notificationPrefix . $e->getMessage());
                    $this->getResponse()->setHttpResponseCode(500); // Internal Server Error (Exception)
                }

            } else {
                Codex_Yapital_Model_Log::error($notificationPrefix . 'invalid secret');
                $this->getResponse()->setHttpResponseCode(403); // Invalid Secret, Forbidden
            }


        } else {
            Codex_Yapital_Model_Log::log('notification: empty request');
            $this->getResponse()->setHttpResponseCode(200); // Incase of not sending 200 everything breaks!
        }

        $this->getResponse()->setBody('fin');
    }

}
