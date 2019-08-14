<?php
/**
 * Defines the Currency datatype for the Yapital API
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
 * The Currency type specifies the currency that is used for a basket.
 *
 * Enumeration values:
 *
 * Value    Type    Description
 * EUR      string  The basket currency is Euro.
 * USD      string  The basket currency is US Dollars (not supported in the current implementation).
 *
 * @category   Datatype
 * @package    Codex_Yapital_Model_Datatype
 * @copyright  2013 Code-X GmbH
 * @link       http://code-x.de
 * @since      Class available since Release 0.1.0
 */
class Codex_Yapital_Model_Datatype_Currency extends Codex_Yapital_Model_Datatype_AbstractSimpleType
{

    const EUR = "EUR";
    //const USD = "USD";
}

