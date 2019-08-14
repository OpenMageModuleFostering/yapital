<?php
/**
 * Defines the abstract datatype for all other datatypes of the Yapital API
 *
 *
 * PHP version 5.2
 *
 *
 * @category   Datatype
 * @package    Codex_Yapital
 */

/**
 * The abstract type specifies the common operations on all other datatypes for the Yapital API.
 *
 * This would be generating a JSON or XML output.
 *
 * @category   Datatype
 * @package    Codex_Yapital
 */
abstract class Codex_Yapital_Model_Datatype_Abstract extends Varien_Object
    implements Codex_Yapital_Model_Datatype_Interface
{

    protected $_yapitalConfig;

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

        $theArray = $this->toArray(); // pull as variable for faster handling

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

    public function toArray ()
    {
        return $this->_toArray($this->getData());
    }

    /**
     * Get an array representation of this data type.
     *
     * This will make an multidimensional array which contains all fields and their values
     * down to simple strings, floats or integer.
     *
     * @runtime O(n)
     *
     * @throws Codex_Yapital_ErrorException
     *
     * @return array
     */
    protected function _toArray ( $theData )
    {
        $toArray = array();

        // iterate over fields and values
        foreach ( $theData as $key => $value )
        {

            if ( $value instanceof Codex_Yapital_Model_Datatype_Interface )
            {
                // it is another yapital data type: get it's array representation
                $toArray[$key] = $value->toArray();
            }
            else if ( is_array($value) )
            {
                $tmp = $this->_toArray($value);

                // export only those with data in it
                if ( 0 < count($tmp) )
                {
                    $toArray[$key] = $tmp;
                }
            }
            else if ( is_scalar($value) )
            {
                $toArray[$key] = $value;
            }
            else if ( $value === null )
            {
                // has no data: don't export it
            }
            else
            {
                // it is unknown: throw error
                throw new Codex_Yapital_ErrorException(
                    "Unhandled type of data in key $key: "
                    . ( is_object($value) ) ? get_class($value) : gettype($value)
                );
            }
        }

        return $toArray;
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



}
