<?php
/**
 * Defines the TransactionStatus datatype for the Yapital API
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
 * The TransactionStatus type specifies the details of a transaction.
 *
 * Used by methods
 *
 * Request:
 *  - POST shops/{id}/baskets/{id}/transaction
 * Response:
 *  - GET shops/{shopId}/baskets/{basketId}/transaction
 *
 *
 * @category   Datatype
 * @package    Codex_Yapital_Model_Datatype
 * @copyright  2013 Code-X GmbH
 * @link       http://code-x.de
 * @since      Class available since Release 0.1.0
 */
class Codex_Yapital_Model_Datatype_TransactionStatus
{

    const REQUESTED = "REQUESTED";
    const INVALID   = "INVALID";
    const CANCELLED = "CANCELLED";
    const PAID      = "PAID";
}
