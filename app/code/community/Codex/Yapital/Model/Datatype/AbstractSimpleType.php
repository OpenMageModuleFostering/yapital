<?php
/**
 * Defines the abstract datatype for all other datatypes of the Yapital API
 *
 *
 * PHP version 5.2
 *
 *
 * @category   Yapital
 * @package    Codex_Yapital_Model_Datatype
 * @copyright  2013 Code-X GmbH
 * @link       http://code-x.de
 * @since      File available since Release 0.1.0
 */

/**
 * The abstract type specifies the common operations on all other datatypes for the Yapital API.
 *
 * This would be generating a JSON or XML output.
 *
 * @category   Yapital
 * @package    Codex_Yapital_Model_Datatype
 * @copyright  2013 Code-X GmbH
 * @version    Release: @package_version@
 * @link       http://code-x.de
 * @since      Class available since Release 0.1.0
 */
abstract class Codex_Yapital_Model_Datatype_AbstractSimpleType
    implements Codex_Yapital_Model_Datatype_Interface
{

    protected $_yapitalConfig;
    protected $_value;

    /**
     * Gets the Config model
     *
     * @return \Codex_Yapital_Model_Config
     */
    protected function _getConfig() {
        if (null == $this->_yapitalConfig) {
            $this->_yapitalConfig = Mage::getSingleton('yapital/config');
        }
        return $this->_yapitalConfig;
    }

    /**
     * Empty constructor for magento
     */
    function __construct ()
    {

    }

    /**
     * Get an JSON representation of this data type.
     *
     * This will make an multidimensional JSON-Object which contains all fields and their values
     * down to simple strings, floats or integer.
     *
     * @runtime O(n)
     *
     * @return string
     */
    public function toJSON ()
    {

        $theArray = $this->toString(); // pull as variable for faster handling

        return json_encode($theArray);
    }

    /**
     * Get an XML representation of this data type.
     *
     * This will generate XML-Source with the fields as Container and their value as CDATA in it.
     *
     * @runtime O(n)
     *
     * @return bool
     */
    public function toXML ()
    {

        $toXML = "";

        // init xml parser and data
        $xmlSerializer = new XML_Serializer( XML_SERIALIZER_OPTION_RETURN_RESULT );
        $theArray      = $this->toArray(); // pull as variable for faster handling

        // parse the data
        $toXML = $xmlSerializer->serialize($theArray);

        return $toXML;
    }

    function toString() {
        return $this->getData();
    }

    function setValue($value) {
        $this->_value = $value;
    }

    function getValue() {
        return $this->_value;
    }

    function toArray() {
        return $this->getData();
    }

    /**
     * Get the field-names that can be set by the data type
     *
     * Notice: This can not be called from the method "getData()".
     *
     * @uses getData
     *
     * @return array enum array with fields
     */
    public function getFields ()
    {

        return array_keys($this->getData());
    }

    public function getData() {
        return $this->toString();
    }



}
