<?php

class Codex_Yapital_Model_Api_Client extends Zend_Service_Abstract
{

    /**
     * Data for the query
     * @var array
     */
    protected $_data = array();

    protected $_token;

    /**
     * Zend_Uri of this web service
     * @var Zend_Uri_Http
     */
    protected $_uri = null;

    public function __construct()
    {
        $adapter = new Zend_Http_Client_Adapter_Curl();

        $adapter->setCurlOption(CURLOPT_SSL_VERIFYPEER, 0);
        $adapter->setCurlOption(CURLOPT_SSL_VERIFYHOST, 0);

        $configModel = Mage::getSingleton('yapital/config');


        $uri = $configModel->getApiUrl() . $configModel->getApiUrlPath();
        $this->_uri = Zend_Uri::factory($uri);

        self::getHttpClient()->setAdapter($adapter);

    }

    public function getToken()
    {

        if (null == $this->_token)
        {
            /* @var Codex_Yapital_Model_Api_Token $tokenModel */
            $tokenApi = Mage::getModel('yapital/api_token');

            /** @var Codex_Yapital_Model_Datatype_Token $tokenModel */
            $tokenModel = $tokenApi->getTokenByStoreConfig();

            $this->_token = $tokenModel->getAccessToken();
        }

        return $this->_token;
    }


    /**
     * Send a REST POST Query.
     *
     * @param        $path
     * @param array $query
     * @param string $data
     *
     * @return Zend_Http_Response
     */
    public function restPostQuery($path, $query = array(), $data = '')
    {
        $this->_prepareRest($path);
        $client = self::getHttpClient();
        $client->setParameterGet($query);
        $client->setRawData($data);

        self::getHttpClient()->setEncType(false);

        return $client->request('POST');
    }

    /**
     * Call a remote REST web service URI and return the Zend_Http_Response object
     *
     * @param  string $path The path to append to the URI
     * @throws Zend_Rest_Client_Exception
     * @return void
     */
    private function _prepareRest($path)
    {
        // Get the URI object and configure it
        if (!$this->_uri instanceof Zend_Uri_Http) {
            #require_once 'Zend/Rest/Client/Exception.php';
            throw new Zend_Rest_Client_Exception('URI object must be set before performing call');
        }

        $uri = $this->_uri->getUri();

        if ($path[0] != '/' && $uri[strlen($uri) - 1] != '/') {
            $path = '/' . $path;
        }

        $this->_uri->setPath($path);

        $this->getHttpClient()->setUri($this->_uri);
    }

    public function restDeleteQuery($path, $query)
    {
        $this->_prepareRest($path);
        $client = self::getHttpClient();
        $client->setParameterGet($query);
        return $client->request('DELETE');
    }

    public function resetHttpClient()
    {
        /**
         * Get the HTTP client and configure it for the endpoint URI.  Do this each time
         * because the Zend_Http_Client instance is shared among all Zend_Service_Abstract subclasses.
         */
        self::getHttpClient()->resetParameters(true);

        //
        // Only Accept JSON
        self::getHttpClient()->setHeaders('Accept', 'application/json');

        //
        // Only send json
        self::getHttpClient()->setHeaders('Content-Type', 'application/json');

    }

    /**
     * Performs an HTTP GET request to the $path.
     *
     * @param string $path
     * @param array $query Array of GET parameters
     * @throws Zend_Http_Client_Exception
     * @return Zend_Http_Response
     */
    public function restGet($path, array $query = null)
    {
        $this->_prepareRest($path);
        $client = self::getHttpClient();
        $client->setParameterGet($query);
        return $client->request('GET');
    }

    public function request($type = 'GET', $path = null, $query = null)
    {
        $this->_prepareRest($path);
        $client = self::getHttpClient();
        $client->setParameterGet($query);
        return $client->request($type);
    }

    /**
     * Performs an HTTP POST request to $path.
     *
     * @param string $path
     * @param mixed $data Raw data to send
     * @throws Zend_Http_Client_Exception
     * @return Zend_Http_Response
     */
    final public function restPost($path, $data = null)
    {
        $this->_prepareRest($path);
        return $this->_performPost('POST', $data);
    }

    /**
     * Perform a POST or PUT
     *
     * Performs a POST or PUT request. Any data provided is set in the HTTP
     * client. String data is pushed in as raw POST data; array or object data
     * is pushed in as POST parameters.
     *
     * @param mixed $method
     * @param mixed $data
     * @return Zend_Http_Response
     */
    function _performPost($method, $data = null)
    {
        $client = self::getHttpClient();
        if (is_string($data)) {
            $client->setRawData($data);
        } elseif (is_array($data) || is_object($data)) {
            $client->setParameterPost((array)$data);
        }

        $_performPost = $client->request($method);
        $status = $_performPost->getStatus();

        if (substr($status, 0, 1) != 2) {
            Codex_Yapital_Model_Log::error("Unable to communicate with api. " . $_performPost->getMessage());
        }
        return $_performPost;
    }

    /**
     * Performs an HTTP PUT request to $path.
     *
     * @param string $path
     * @param mixed $data Raw data to send in request
     * @throws Zend_Http_Client_Exception
     * @return Zend_Http_Response
     */
    public function restPut($path, $data = null)
    {
        $this->_prepareRest($path);
        return $this->_performPost('PUT', $data);
    }

    /**
     * Performs an HTTP DELETE request to $path.
     *
     * @param string $path
     * @throws Zend_Http_Client_Exception
     * @return Zend_Http_Response
     */
    public function restDelete($path)
    {
        $this->_prepareRest($path);
        return self::getHttpClient()->request('DELETE');
    }


}
