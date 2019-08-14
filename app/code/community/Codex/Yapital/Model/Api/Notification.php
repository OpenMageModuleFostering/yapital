<?php

class Codex_Yapital_Model_Api_Notification extends Codex_Yapital_Model_Api_Abstract {

    /**
     * @param Codex_Yapital_Model_Datatype_Notification $data
     *
     * @return Codex_Yapital_Model_Datatype_Shoprestresponse
     */
    public function register( Codex_Yapital_Model_Datatype_Notification $data ) {

        Codex_Yapital_Model_Log::log("Registering new notification.");

        $url = "/shops/" . $this->_getConfig()->getYapitalShopId() . "/notifications";

        $send = $this->_send($url, $data);

        /**
         * @var $register Codex_Yapital_Model_Datatype_Shoprestresponse
         */
        $register = Mage::getModel("yapital/datatype_shoprestresponse");
        $register->importRawResponse($send);

        return $register;
    }

    public function delete( $notification_id )
    {
        if ( $this->get( $notification_id ) )
        {
            $query_data = $this->_getQuery();
            $url = $this->_getConfig()->getApiUrlPath().'/shops/'.$this->_getConfig()->getYapitalShopId().'/notifications/'.$notification_id;

            $this->getClient()->resetHttpClient();
            $response = $this->getClient()->restDeleteQuery( $url, $query_data );

            if ( $response->isError() )
            {
                throw new Codex_Yapital_ErrorException("could not delete notification $notification_id");
            }
        }

        return $this;
    }

    public function getAll()
    {
        $result = array();

        $query_data = $this->_getQuery();
        $url = $this->_getConfig()->getApiUrlPath().'/shops/'.$this->_getConfig()->getYapitalShopId().'/notifications';

        $this->getClient()->resetHttpClient();
        $response = $this->getClient()->restGet( $url, $query_data )->getBody();

        if ( $data = json_decode($response,1) )
        {

            foreach( $data['payload'] AS $payload ) {
                $notification = Mage::getModel('yapital/datatype_notification');
                /* @var $notification Codex_Yapital_Model_Datatype_Notification */

                $notification->importPayload( $payload );

                $result[] = $notification;
            }

        }

        return $result;
    }

    public function get( $notification_id )
    {
        $query_data = $this->_getQuery();
        $url = $this->_getConfig()->getApiUrlPath().'/shops/'.$this->_getConfig()->getYapitalShopId().'/notifications/'.$notification_id;

        $this->getClient()->resetHttpClient();
        $response = $this->getClient()->restGet( $url, $query_data )->getBody();

        if ( $data = json_decode($response,1) ) {
            $notification = Mage::getModel('yapital/datatype_notification');
            /* @var $notification Codex_Yapital_Model_Datatype_Notification */

            $notification->importPayload( $data['payload'] );
            return $notification;
        }

        throw new Codex_Yapital_ErrorException('could not get notification_id '.$notification_id);
    }

}
