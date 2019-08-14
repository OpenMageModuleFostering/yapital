<?php
/**
 * Defines the EventType simple datatype for the Yapital API
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
 * The EventType type defines the event types for which a notification can be created.
 *
 * In the current implementation, the Yapital Shop API supports only the payment_processed notifications.
 *
 * @category   Datatype
 * @package    Codex_Yapital_Model_Datatype
 * @copyright  2013 code-x GmbH
 * @link       http://code-x.de
 * @since      Class available since Release 0.1.0
 */
class Codex_Yapital_Model_Datatype_EventType extends Codex_Yapital_Model_Datatype_AbstractSimpleType
    implements Codex_Yapital_Model_Datatype_Interface
{

    const PAYMENT_PROCESSED = "PAYMENT_PROCESSED";
}
