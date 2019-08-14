<?php
/**
 * Defines the AirlineData datatype for the Yapital API
 *
 *
 * PHP version 5
 *
 *
 * @category   Yapital
 * @package    Codex_Yapital_Model_Datatype
 * @copyright  2013 Code-X GmbH
 * @link       http://code-x.de
 * @since      File available since Release 0.1.0
 */

/**
 * The AirlineData type specifies the details of an airline ticket purchase.
 *
 * Used by methods
 *
 * Note: The methods are not implemented yet.
 *  - POST shops/{id}/baskets/{id}/airline_data
 *  - GET shops/{id}/baskets/{id}/airline_data
 *  - PUT shops/{id}/baskets/{id}/airline_data
 *  - DELETE shops/{id}/baskets/{id}/airline_data
 *
 *
 * @category   Yapital
 * @package    Codex_Yapital_Model_Datatype
 * @copyright  2013 Code-X GmbH
 * @version    Release: @package_version@
 * @link       http://code-x.de
 * @since      Class available since Release 0.1.0
 */
class Codex_Yapital_Model_Datatype_AirlineData extends Codex_Yapital_Model_Datatype_Abstract
    implements Codex_Yapital_Model_Datatype_Interface
{

    /**
     * @var string
     */
    protected $_ticketDocumentNumber = "";
    /**
     * @var string
     */
    protected $_passengerName = "";
    /**
     * @var string
     */
    protected $_flightDate = "";
    /**
     * @var string
     */
    protected $_flightCoupon = "";
    /**
     * @var string
     */
    protected $_originAirportCityCode = "";
    /**
     * @var string
     */
    protected $_destinationAirportCityCode = "";
    /**
     * @var string
     */
    protected $_carrier = "";

    /**
     * @param string $carrier
     */
    public function setCarrier ( $carrier )
    {

        $this->_carrier = $carrier;

        return $this;
    }

    /**
     * @return string
     */
    public function getCarrier ()
    {

        return $this->_carrier;
    }

    /**
     * @param string $destinationAirportCityCode
     */
    public function setDestinationAirportCityCode ( $destinationAirportCityCode )
    {

        $this->_destinationAirportCityCode = $destinationAirportCityCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getDestinationAirportCityCode ()
    {

        return $this->_destinationAirportCityCode;
    }

    /**
     * @param string $flightCoupon
     */
    public function setFlightCoupon ( $flightCoupon )
    {

        $this->_flightCoupon = $flightCoupon;

        return $this;
    }

    /**
     * @return string
     */
    public function getFlightCoupon ()
    {

        return $this->_flightCoupon;
    }

    /**
     * @param string $flightDate
     */
    public function setFlightDate ( $flightDate )
    {

        $this->_flightDate = $flightDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getFlightDate ()
    {

        return $this->_flightDate;
    }

    /**
     * @param string $originAirportCityCode
     */
    public function setOriginAirportCityCode ( $originAirportCityCode )
    {

        $this->_originAirportCityCode = $originAirportCityCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getOriginAirportCityCode ()
    {

        return $this->_originAirportCityCode;
    }

    /**
     * @param string $passengerName
     */
    public function setPassengerName ( $passengerName )
    {

        $this->_passengerName = $passengerName;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassengerName ()
    {

        return $this->_passengerName;
    }

    /**
     * @param string $ticketDocumentNumber
     */
    public function setTicketDocumentNumber ( $ticketDocumentNumber )
    {

        $this->_ticketDocumentNumber = $ticketDocumentNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getTicketDocumentNumber ()
    {

        return $this->_ticketDocumentNumber;
    }


    function getData ()
    {

        return array(
            "ticket_document_number"        => $this->getTicketDocumentNumber(),
            "passenger_name"                => $this->getPassengerName(),
            "flight_date"                   => $this->getFlightDate(),
            "flight_coupon"                 => $this->getFlightCoupon(),
            "origin_airport_city_code"      => $this->getOriginAirportCityCode(),
            "destination_airport_city_code" => $this->getDestinationAirportCityCode(),
            "carrier"                       => $this->getCarrier(),
        );
    }
}
