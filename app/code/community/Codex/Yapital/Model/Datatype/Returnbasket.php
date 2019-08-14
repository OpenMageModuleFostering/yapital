<?php
/**
 * Defines the PostalAddress datatype for the Yapital API
 *
 *
 * PHP version 5
 *
 *
 * @category   Datatype
 * @package    Codex_Yapital
 */

/**
 * The ReturnBasket type specifies the amount to credit to a Web shop customer in a basket return transaction.
 *
 * Request:
 *
 * - POST shops/{shopId}/transactions/{transactionId}/return_basket
 *
 *
 * @category   Datatype
 * @package    Codex_Yapital
 *
 * @method Codex_Yapital_Model_DataType_Amount getAmountToCredit() The amount of money a Web shop wants to return to its customer.
 * @method int setAmountToCredit(Codex_Yapital_Model_DataType_Amount $value) The amount of money a Web shop wants to return to its customer.
 */
class Codex_Yapital_Model_Datatype_Returnbasket extends Codex_Yapital_Model_Datatype_Abstract
    implements Codex_Yapital_Model_Datatype_Interface
{
    const AMOUNT_TO_CREDIT = 'amount_to_credit';

    const ID = 'basket_to_return';


    public function toArray()
    {
        $toArray = array(self::ID => parent::toArray());

        return $toArray;
    }
}
