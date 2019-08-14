<?php
/**
 * Defines the PostalAddress datatype for the Yapital API
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
 * The PostalAddress type specifies the billing or the shipping addresses.
 *
 * The PostalAddress type specifies the billing or the shipping addresses of the Web shop customer who
 * makes a purchase. This data type is used for both the billing and the shipping address objects.
 *
 * Used by methods
 *
 * Requests:
 *  - POST shops/{shopId}/baskets/{basketId}/billing_address
 *  - POST shops/{shopId}/baskets/{basketId}/shipping_address
 *  - PUT shops/{shopId}/baskets/{basketId}/billing_address
 *  - PUT shops/{shopId}/baskets/{basketId}/shipping_address
 *
 * Responses:
 *  - GET shops/{shopId}/baskets/{basketId}/billing_address
 *  - GET shops/{shopId}/baskets/{basketId}/shipping_address
 *
 *
 * @category   Datatype
 * @package    Codex_Yapital_Model_Datatype
 * @copyright  2013 Code-X GmbH
 * @link       http://code-x.de
 * @since      Class available since Release 0.1.0
 */
class Codex_Yapital_Model_Datatype_PostalAddress extends Codex_Yapital_Model_Datatype_Abstract
    implements Codex_Yapital_Model_Datatype_Interface
{

    /**
     * @var string
     */
    protected $_title;
    /**
     * @var string
     */
    protected $_firstName;
    /**
     * @var string
     */
    protected $_lastName;
    /**
     * @var string
     */
    protected $_adress1;
    /**
     * @var string
     */
    protected $_address2;
    /**
     * @var string
     */
    protected $_city;
    /**
     * @var string
     */
    protected $_zip;
    /**
     * @var string
     */
    protected $_country;
    /**
     * @var string
     */
    protected $_state;
    /**
     * @var boolean
     */
    protected $_readonly;

    /**
     * @param string $address2
     */
    public function setAddress2 ( $address2 )
    {

        $this->_address2 = $address2;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress2 ()
    {

        return $this->_address2;
    }

    /**
     * @param string $adress1
     */
    public function setAddress1 ( $adress1 )
    {

        $this->_adress1 = $adress1;

        return $this;
    }

    /**
     * @return string
     */
    public function getAdress1 ()
    {

        return $this->_adress1;
    }

    /**
     * @param string $city
     */
    public function setCity ( $city )
    {

        $this->_city = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getCity ()
    {

        return $this->_city;
    }

    /**
     * @param string $country
     */
    public function setCountry ( $country )
    {

        $this->_country = $country;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry ()
    {

        return $this->_country;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName ( $firstName )
    {

        $this->_firstName = $firstName;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName ()
    {

        return $this->_firstName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName ( $lastName )
    {

        $this->_lastName = $lastName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName ()
    {

        return $this->_lastName;
    }

    /**
     * @param boolean $readonly
     */
    public function setReadonly ( $readonly )
    {

        $this->_readonly = $readonly;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getReadonly ()
    {

        return $this->_readonly;
    }

    /**
     * @param string $state
     */
    public function setState ( $state )
    {

        $this->_state = $state;

        return $this;
    }

    /**
     * @return string
     */
    public function getState ()
    {

        return $this->_state;
    }

    /**
     * @param string $title
     */
    public function setTitle ( $title )
    {

        $this->_title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle ()
    {

        return $this->_title;
    }

    /**
     * @param string $zip
     */
    public function setZip ( $zip )
    {

        $this->_zip = $zip;

        return $this;
    }

    /**
     * @return string
     */
    public function getZip ()
    {

        return $this->_zip;
    }

    /**
     * Imports an order address into the Yapital Postaladdress
     *
     * @param Mage_Sales_Model_Order_Address $address
     *
     * @todo street3 ? street4 ? unhandled by api
     *
     * @return \Codex_Yapital_Model_Datatype_PostalAddress
     */
    public function importOrderAddress ( Mage_Sales_Model_Order_Address $address )
    {

        $this->setTitle($address->getPrefix());
        $this->setFirstName($address->getFirstname());
        $this->setLastName($address->getLastname());
        $this->setAddress1($address->getStreet1());
        $this->setAddress2($address->getStreet2());
        $this->setCity($address->getCity());
        $this->setZip($address->getPostcode());
        $this->setCountry($address->getCountry());
        $this->setReadonly(true);

        return $this;
    }

    function getData ()
    {
        return array(
            "title"      => (string) $this->getTitle(),
            "first_name" => $this->getFirstName(),
            "last_name"  => $this->getLastName(),
            "address_1"  => $this->getAdress1(),
            "address_2"  => $this->getAddress2(),
            "city"       => $this->getCity(),
            "zip"        => $this->getZip(),
            "country"    => $this->getCountry(),
            "state"      => $this->getState(),
            // "readonly"   => $this->getReadonly(),
        );
    }
}
