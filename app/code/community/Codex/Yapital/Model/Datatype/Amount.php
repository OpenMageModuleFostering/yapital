<?php
/**
 * Defines the Amount datatype for the Yapital API
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
 * The Amount type specifies a money amount and a currency.
 *
 *
 * @category   Datatype
 * @package    Codex_Yapital_Model_Datatype
 * @copyright  2013 Code-X GmbH
 * @version    Release: @package_version@
 * @link       http://code-x.de
 * @since      Class available since Release 0.1.0
 */
class Codex_Yapital_Model_Datatype_Amount extends Codex_Yapital_Model_Datatype_Abstract
    implements Codex_Yapital_Model_Datatype_Interface
{

    /**
     * Indicates the currency of a current amount.
     *
     * @var string
     */
    protected $_currency;

    /**
     * The amount value
     *
     * @var float
     */
    protected $_value;

    /**
     * @param string $currency
     */
    public function setCurrency ( $currency )
    {

        $this->_currency = $currency;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency ()
    {

        return $this->_currency;
    }

    /**
     * @param float $value
     */
    public function setValue ( $value )
    {

        $this->_value = $value;

        return $this;
    }

    /**
     * @return float
     */
    public function getValue ()
    {

        return $this->_value;
    }


    /**
     * Generate a assoc array representation of the Amount
     *
     * @return array
     */
    public function getData ()
    {

        return array(
            "currency" => $this->getCurrency(),
            "value"    => $this->getValue(),
        );
    }
}
