<?php
/**
 * Defines the BasketTransactionCreated datatype for the Yapital API
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
 * The BasketTransactionCreated type is used to return data about a newly created basket.
 *
 * ## Description
 *
 * The BasketTransactionCreated type is used to return data about a newly created basket:
 *  - basket ID
 *  - transaction ID
 *  - redirect URL
 *
 * ## Used by methods
 *
 * Request:
 *  - POST shops/{shopId}/basket_transaction
 *
 * @category   Datatype
 * @package    Codex_Yapital_Model_Datatype
 * @copyright  2013 Code-X GmbH
 * @link       http://code-x.de
 * @since      Class available since Release 0.1.0
 */
class Codex_Yapital_Model_Datatype_BasketTransactionCreated extends Codex_Yapital_Model_Datatype_Abstract
    implements Codex_Yapital_Model_Datatype_Interface
{

    /**
     * @var Codex_Yapital_Model_Datatype_YapitalPublicId
     */
    protected $_basketId;

    /**
     * @var Codex_Yapital_Model_Datatype_YapitalPublicId
     */
    protected $_transactionId;

    /**
     * @var string
     */
    protected $_redirectUrl;

    /**
     * @return \Codex_Yapital_Model_Datatype_YapitalPublicId
     */
    public function getBasketId ()
    {

        return $this->_basketId;
    }

    /**
     * @return string
     */
    public function getRedirectUrl ()
    {

        return $this->_redirectUrl;
    }

    /**
     * @return \Codex_Yapital_Model_Datatype_YapitalPublicId
     */
    public function getTransactionId ()
    {

        return $this->_transactionId;
    }

    /**
     * @param \Codex_Yapital_Model_Datatype_YapitalPublicId $basketId
     */
    public function setBasketId ( $basketId )
    {

        $this->_basketId = $basketId;

        return $this;
    }

    /**
     * @param string $redirectUrl
     */
    public function setRedirectUrl ( $redirectUrl )
    {

        $this->_redirectUrl = $redirectUrl;

        return $this;
    }

    /**
     * @param \Codex_Yapital_Model_Datatype_YapitalPublicId $transactionId
     */
    public function setTransactionId ( $transactionId )
    {

        $this->_transactionId = $transactionId;

        return $this;
    }


    /**
     * Generate associative array that containts the fields with its values
     *
     * @return array
     */
    public function getData ()
    {

        return array(
            "basket_id"      => $this->getBasketId(),
            "transaction_id" => $this->getTransactionId(),
            "redirect_url"   => $this->getRedirectUrl(),
        );
    }
}
