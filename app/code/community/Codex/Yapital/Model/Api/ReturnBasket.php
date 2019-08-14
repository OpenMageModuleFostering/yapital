<?php
/**
 * Contains class.
 *
 * PHP version 5
 *
 */

/**
 * Class ReturnBasket.
 *
 * @category   yapital-magento
 */
class Codex_Yapital_Model_Api_ReturnBasket extends Codex_Yapital_Model_Api_Abstract
{
    const URL = '/shops/%s/transactions/%s/return_basket';

    public function send($shopId, $transactionId, $returnBasket)
    {
        $url = $this->_makeUrl($shopId, $transactionId);

        return $this->_send($url, $returnBasket);
    }


}
