<?php
/**
 * Defines the Notification datatype for the Yapital API
 *
 *
 * PHP version 5
 *
 *
 * @category   Datatype
 * @package    Codex_Yapital_Model_Datatype
 * @copyright  2013 Code-X GmbH
 * @link       http://code-x.de
 * @since      File available since Release 0.1.0
 */

/**
 * The Notification type defines the data structure of a notification.
 *
 * ## Used by methods
 *
 * Requests:
 *  - Create a new notification endpoint : POST shops/{shopId}/notifications
 *  - Update the notification: PUT shops/{shopId}/notifications/{notificationId}
 *
 * Response:
 *  - Get the notification by the Public ID: GET shops/{shopId}/notifications/{notificationId}
 *  - Get all notifications for the specified Web shop: GET shops/{shopId}/notifications
 *
 *
 * @category   Datatype
 * @package    Codex_Yapital_Model_Datatype
 * @copyright  2013 Code-X GmbH
 * @link       http://code-x.de
 * @since      Class available since Release 0.1.0
 */
class Codex_Yapital_Model_Datatype_Notification extends Codex_Yapital_Model_Datatype_Abstract
    implements Codex_Yapital_Model_Datatype_Interface
{

    /**
     * @var Codex_Yapital_Model_Datatype_YapitalPublicId
     */
    protected $_notificationId;

    /**
     * @var string
     */
    protected $_eventType;

    /**
     * @var string
     */
    protected $_callbackUrl;

    /**
     * @var string
     */
    protected $_validationStatus;

    /**
     * @var string
     */
    protected $_acceptType;

    /**
     * @param \Codex_Yapital_Model_Datatype_YapitalPublicId $notificationId
     */
    public function setNotificationId ( $notificationId )
    {

        $this->_notificationId = $notificationId;
    }

    /**
     * @return \Codex_Yapital_Model_Datatype_YapitalPublicId
     */
    public function getNotificationId ()
    {

        return $this->_notificationId;
    }

    /**
     * @param string $eventType
     */
    public function setEventType ( $eventType )
    {

        $this->_eventType = $eventType;
    }

    /**
     * @return string
     */
    public function getEventType ()
    {

        return (string) $this->_eventType;
    }

    /**
     * @param string $callbackUrl
     */
    public function setCallbackUrl ( $callbackUrl )
    {
        $this->_callbackUrl = $callbackUrl;
    }

    /**
     * @return string
     */
    public function getCallbackUrl ()
    {

        return (string) $this->_callbackUrl;
    }

    /**
     * @param string $acceptType
     */
    public function setAcceptType ( $acceptType )
    {

        $this->_acceptType = $acceptType;
    }

    /**
     * @return string
     */
    public function getAcceptType ()
    {

        return (string) $this->_acceptType;
    }

    /**
     * @param string $validationStatus
     */
    public function setValidationStatus ( $validationStatus )
    {

        $this->_validationStatus = $validationStatus;
    }

    /**
     * @return string
     */
    public function getValidationStatus ()
    {

        return $this->_validationStatus;
    }

    public function importPayload( array $payload )
    {
        $this->setNotificationId( $payload['notification_id'] );
        $this->setEventType( $payload['event_type'] );
        $this->setCallbackUrl( $payload['callback_url'] );
        $this->setValidationStatus( $payload['validation_status'] );
        $this->setAcceptType( $payload['accept_type'] );

        return $this;
    }

    public function getData ()
    {

        return array(
            "notification" =>
            array(
            //"notification_id"   => $this->getNotificationId(),
            "event_type"        => $this->getEventType(),
            "callback_url"      => $this->getCallbackUrl(),
            "validation_status" => $this->getValidationStatus(),
            "accept_type"       => $this->getAcceptType(),
        )
        );
    }
}
