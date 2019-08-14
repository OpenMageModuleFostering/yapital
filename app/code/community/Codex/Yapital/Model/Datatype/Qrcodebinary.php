<?php
/**
 * Defines the QRCodeBinary datatype for the Yapital API
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
 * The Basket type specifies the details of the basket an its contents.
 *
 * Contains the data about the items in the basket, including the item price and other details.
 *
 * @category   Datatype
 * @package    Codex_Yapital_Model_Datatype
 * @copyright  2013 Code-X GmbH
 * @link       http://code-x.de
 * @since      Class available since Release 0.1.0
 */
class Codex_Yapital_Model_Datatype_QRCodeBinary extends Codex_Yapital_Model_Datatype_Abstract
    implements Codex_Yapital_Model_Datatype_Interface
{

    /**
     * Base64 encode QR code image.
     *
     * @var string
     */
    protected $_value;

    /**
     * Additional metainformation (empty array at the current stage of implementation).
     *
     * @var array
     */
    protected $_metadata = array();

    /**
     * Application/octet-stream.
     *
     * @var string
     */
    protected $_mimetype = "application/octet-stream";

    /**
     * @return array
     */
    public function getMetadata ()
    {

        return $this->_metadata;
    }

    /**
     * @return string
     */
    public function getMimetype ()
    {

        return $this->_mimetype;
    }

    /**
     * @param string $value
     */
    public function setValue ( $value )
    {

        $this->_value = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue ()
    {

        return $this->_value;
    }

    /**
     * @param array $metadata
     */
    public function setMetadata ( $metadata )
    {

        $this->_metadata = $metadata;

        return $this;
    }

    /**
     * @param string $mimetype
     */
    public function setMimetype ( $mimetype )
    {

        $this->_mimetype = $mimetype;

        return $this;
    }


    public function getData ()
    {

        return array(
            "mimetype" => $this->getMimetype(),
            "metadata" => $this->getMetadata(),
            "value"    => $this->getValue(),
        );
    }
}
