<?php

class Codex_Yapital_NotificationController extends Mage_Core_Controller_Front_Action {

    public function receiveAction() {

        $notification = Mage::getModel('yapital/notification');
        /* @var $notification Codex_Yapital_Model_Notification */

        $json = $this->getRequest()->getRawBody();
        if ( $this->getRequest()->getParam('debug_json') != '' ) {
            $json = $this->getRequest()->getParam('debug_json');
        }

        $data = json_decode( $json , true );
        if ( is_array( $data ) || true ) {
            $notification->import( $data );

            if ( $notification->getSecret() != '' && $notification->getSecret() == $this->getRequest()->getParam('secret') )
            {
                try {
                    $notification->save();
                    $notification->processOrder();
                    $this->getResponse()->setHttpResponseCode(200); // OK
                } catch ( Exception $e ) {
                    Codex_Yapital_Model_Log::error( "notification:" .$e->getMessage() );
                    $this->getResponse()->setHttpResponseCode(500); // Internal Server Error (Exception)
                }

            } else {
                Codex_Yapital_Model_Log::error('notification: invalid secret');
                $this->getResponse()->setHttpResponseCode(403); // Invalid Secret, Forbidden
            }


        } else {
            Codex_Yapital_Model_Log::error('notification: empty request');
            $this->getResponse()->setHttpResponseCode(200); // To validate Notifications
        }

        $this->getResponse()->setBody('fin');
    }

}
