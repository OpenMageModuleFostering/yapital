<?php

class Codex_Yapital_Model_Api_Abstract
{

    /* @var Codex_Yapital_Model_Api_Restclient */
    protected $_client;

    protected $_yapitalConfig;

    const URL = '/';


    /**
     * @return Codex_Yapital_Model_Api_Restclient
     */
    public function getClient()
    {
        if (!$this->_client)
        {
            $config = $this->_getConfig();
            /**
             * @var $config Codex_Yapital_Model_Config
             */
            $this->_client = Mage::getModel('yapital/api_restclient', $config->getApiUrl());
        }

        return $this->_client;
    }


    /**
     * Gets the Config model
     *
     * @return \Codex_Yapital_Model_Config
     */
    protected function _getConfig()
    {
        if (null == $this->_yapitalConfig)
        {
            $this->_yapitalConfig = Mage::getSingleton('yapital/config');
        }

        return $this->_yapitalConfig;
    }


    protected function _getQuery($data = array())
    {
        /** @var $tokenModel Codex_Yapital_Model_Api_Token */
        $tokenModel = Mage::getModel("yapital/api_token");

        $token = $tokenModel->getTokenByCredentials(
            $this->_getConfig()->getApiClientId(),
            $this->_getConfig()->getApiSecret()
        );

        $data['access_token'] = $token->getAccessToken();

        return $data;
    }


    protected function _makeUrl()
    {
        $args = func_get_args();

        foreach( $args AS &$arg ) {
            $arg = urlencode($arg);
        }

        return vsprintf(static::URL, $args);
    }


    /***
     * @see Codex_Yapital_Model_Log
     *
     * @param $url
     * @param $data array
     *
     * @return string
     */
    protected function _send($path, $data)
    {
        $querydata = $this->_getQuery();

        $path = $this->_getConfig()->getApiUrlPath() . $path;
        Codex_Yapital_Model_Log::log("Send request to " . $path );
        Codex_Yapital_Model_Log::debug("Data:" . $data->toJSON() );

        $this->getClient()->resetHttpClient();
        $response = $this->getClient()->restPostQuery($path, $querydata, $data->toJSON())->getBody();

        return $response;
    }
}
