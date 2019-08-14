<?php
/**
 * Defines the YapitalPublicId datatype for the Yapital API
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
 * The YapitalPublicId type is used as a unique ID for any object in the Yapital system.
 *
 * The YapitalPublicId is used for Baskets, Transactions, Web shops, etc.
 *
 * The YapitalPublicId consists of two parts separated by the "-" character:
 *  - prefix that specifies the type of the object, referenced by the public ID.
 *  - suffix that specifies the specific object.
 *
 * Samples IDs:
 *  - S1000-AZ21
 *  - SO100-J08
 *
 * Contains the data about the items in the basket, including the item price and other details.
 *
 * @category   Datatype
 * @package    Codex_Yapital_Model_Datatype
 * @copyright  2013 Code-X GmbH
 * @link       http://code-x.de
 * @see        Codex_Yapital_Model_Datatype_Basket, Codex_Yapital_Model_Datatype_Transaction, ...
 * @since      Class available since Release 0.1.0
 */
class Codex_Yapital_Model_Datatype_YapitalPublicId extends Codex_Yapital_Model_Datatype_Abstract
    implements Codex_Yapital_Model_Datatype_Interface
{

    private $_infix = "-";

    /**
     * prefix that specifies the type of the object, referenced by the public ID.
     *
     * @var string
     */
    protected $_prefix = "";

    /**
     * suffix that specifies the specific object
     *
     * @var string
     */
    protected $_suffix = "";

    /**
     * @param string $prefix
     */
    public function setPrefix ( $prefix )
    {

        $this->_prefix = (string) $prefix;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrefix ()
    {

        return $this->_prefix;
    }

    /**
     * @param string $suffix
     */
    public function setSuffix ( $suffix )
    {

        $this->_suffix = (string) $suffix;

        return $this;
    }

    /**
     * @return string
     */
    public function getSuffix ()
    {

        return $this->_suffix;
    }

    public function importString ( $text )
    {

        list( $prefix, $suffix ) = explode($this->_infix, $text);

        $this->setPrefix($prefix);
        $this->setSuffix($suffix);

        return $this;
    }


    /**
     * @return string
     */
    public function getData ()
    {

        return (string) $this->getPrefix() . $this->_infix . $this->getSuffix();
    }
}
