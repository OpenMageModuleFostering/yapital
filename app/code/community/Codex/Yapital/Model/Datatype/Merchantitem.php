<?php
/**
 * Defines the MerchantItem datatype for the Yapital API
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
 * The MerchantItem type specifies the data the Web shop would like to route through the Yapital Shop API.
 *
 * This gives the Web shop customer an option to add personal data for personal purposes to the Basket.
 * All the data provided is ignored by Yapital but stored with the Basket.
 *
 *
 * @category   Datatype
 * @package    Codex_Yapital_Model_Datatype
 * @copyright  2013 Code-X GmbH
 * @link       http://code-x.de
 * @since      Class available since Release 0.1.0
 */
class Codex_Yapital_Model_Datatype_MerchantItem extends Codex_Yapital_Model_Datatype_Abstract
    implements Codex_Yapital_Model_Datatype_Interface
{

    /**
     * @var string
     */
    protected $_merchantData;

    /**
     * @param string $merchantData
     */
    public function setMerchantData ( $merchantData )
    {

        $this->_merchantData = $merchantData;

        return $this;
    }

    /**
     * @return string
     */
    public function getMerchantData ()
    {

        return $this->_merchantData;
    }

    /**
     * Gets all fields of MerchantData as associative array
     *
     * @return array
     */
    public function getData ()
    {

        if ( "" == $this->getMerchantData() )
        {
            return null;
        }

        return array(
            "merchant_data" => $this->getMerchantData()
        );
    }
}
