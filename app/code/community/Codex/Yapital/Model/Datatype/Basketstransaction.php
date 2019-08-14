<?php
/**
 * Defines the BasketsTransaction datatype for the Yapital API
 *
 *
 * PHP version 5
 *
 *
 * @category   Yapital
 * @package    Codex_Yapital_Model_DataType
 * @copyright  2013 Code-X GmbH
 * @link       http://code-x.de
 * @since      File available since Release 0.1.0
 */

/**
 * The BasketsTransaction type is a composite object that contains a Basket and a Transaction.
 *
 * ## Description
 *
 * The BasketsTransaction type is a composite object that contains data about both a transaction and a
 * basket.
 * This data type is used to create both a new basket and a new transaction by a single API call.
 *
 * ## Used by methods
 *
 * Requests:
 *  - POST shops/{shopId}/basket_transaction
 *
 *
 * @category   Yapital
 * @package    Codex_Yapital_Model_DataType
 * @copyright  2013 Code-X GmbH
 * @link       http://code-x.de
 * @since      Class available since Release 0.1.0
 */
class Codex_Yapital_Model_Datatype_Basketstransaction extends Codex_Yapital_Model_Datatype_Abstract
    implements Codex_Yapital_Model_Datatype_Interface
{

    /**
     * @var Codex_Yapital_Model_Datatype_Basket
     */
    protected $_basket;

    /**
     * @var Codex_Yapital_Model_Datatype_Transaction
     */
    protected $_transaction;

    /**
     * @param \Codex_Yapital_Model_Datatype_Transaction $transaction
     */
    public function setTransaction ( $transaction )
    {
        $this->_transaction = $transaction;
        return $this;
    }

    /**
     * @return \Codex_Yapital_Model_Datatype_Transaction
     */
    public function getTransaction ()
    {
        return $this->_transaction;
    }

    /**
     * @param \Codex_Yapital_Model_Datatype_Basket $basket
     */
    public function setBasket ( $basket )
    {
        $this->_basket = $basket;
        return $this;
    }

    /**
     * @return \Codex_Yapital_Model_Datatype_Basket
     */
    public function getBasket ()
    {
        return $this->_basket;
    }


    public function importOrder ( Mage_Sales_Model_Order $order )
    {
        /**
         * @var $basket Codex_Yapital_Model_Datatype_Basket
         */
        $basket = Mage::getModel(
            "yapital/datatype_basket"
        );
        $basket->importOrder($order);

        /**
         * @var $transaction Codex_Yapital_Model_Datatype_Transaction
         */
        $transaction = Mage::getModel(
            "yapital/datatype_transaction"
        );
        $transaction->importOrder($order);

        $this->setBasket($basket);
        $this->setTransaction($transaction);

        return $this;

    }

    /**
     * Generate assoc array with all possible fields and their value
     *
     * @return array
     */
    public function getData ()
    {
        return array(
            "basket_transaction" =>
            array(
                "basket"      => $this->getBasket(),
                "transaction" => $this->getTransaction(),
            )
        );
    }


}
