<?php

class Codex_Yapital_Model_Api_Token extends Codex_Yapital_Model_Api_Abstract
{

    /**
     * @uses Codex_Yapital_Model_Log , Mage
     *
     * @param string $client_id
     * @param string $secret
     *
     * @return Codex_Yapital_Model_Datatype_Token|false The token as received or `false` if something went wrong.
     */
    public function getTokenByCredentials($client_id, $secret)
    {
        \Codex_Yapital_Model_Log::log(
            "Get new token from authentication server for shop " . $this->_getConfig()->getYapitalShopId()
        );

        $config = $this->_getConfig();
        $client = $this->getClient();

        if (null == $client_id || null == $secret)
        {
            throw new LogicException('ClientId and Secret can not be null');
        }

        $auth = "Basic " . base64_encode($client_id . ":" . $secret);
        $client->resetHttpClient();
        $client->getHttpClient()->setHeaders(
            array(
                 'Accept'          => 'application/json',
                 'Accept-Encoding' => 'gzip,deflate',
                 'Authorization'   => $auth,
                 'Content-Type'    => 'application/x-www-form-urlencoded',
            )
        );

        try
        {
            $path     = $config->getApiUrlPath() . '/oauth/token';
            $response = $client->restPost($path, 'grant_type=client_credentials');

            $client->resetHttpClient();
        } catch (Zend_Http_Client_Exception $e) {

            Codex_Yapital_Model_Log::error(
                sprintf('Connection failure (on %s): %s', $client->getUri(), $e->getMessage())
            );
            return false;
        }

        /** @var $token Codex_Yapital_Model_Datatype_Token */
        $token = Mage::getModel("yapital/datatype_token");

        $token->importArray(json_decode($response->getBody(), true));

        if ($token->getAccessToken() == "")
        {
            Codex_Yapital_Model_Log::error("Could not receive token");
        }
        else
        {
            Codex_Yapital_Model_Log::verbose('Received token.');
        }


        return $token;
    }


    /**
     * @param string $storeId
     * @param string $clientId
     * @param string $secret
     *
     * @return Codex_Yapital_Model_Datatype_Token
     */
    public function getTokenByFullCredentials($storeId, $clientId, $secret)
    {
        $config = $this->_getConfig();
        /**
         * @var $config Codex_Yapital_Model_Config
         */
        $config->setStoreId($storeId);

        return $this->getTokenByCredentials(
            $clientId,
            $secret
        );
    }


    /**
     * @param mixed$store_id
     *
     * @return Codex_Yapital_Model_Datatype_Token
     */
    public function getTokenByStoreConfig($store_id = null)
    {
        $config = $this->_getConfig();
        /**
         * @var $config Codex_Yapital_Model_Config
         */
        $config->setStoreId($store_id);

        return
            $this->getTokenByCredentials(
                $config->getApiClientId(),
                $config->getApiSecret()
            );
    }
}
