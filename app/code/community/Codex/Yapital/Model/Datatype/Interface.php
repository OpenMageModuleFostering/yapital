<?php
/**
 * Defines the interface for datatypes of the Yapital API
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
 * This is the interface of Yapital API datatypes that must be given in every container and datanode.
 *
 * @category   Datatype
 * @package    Codex_Yapital_Model_Datatype
 * @copyright  2013 Code-X GmbH
 * @link       http://code-x.de
 * @since      Class available since Release 0.1.0
 */
interface Codex_Yapital_Model_Datatype_Interface
{

    public function __construct ();

    public function getFields ();

    public function getData ();

    public function toArray ();

    public function toJSON ();

    public function toXML ();
}
