<?php
/**
 * Defines the ShopRestResponse datatype for the Yapital API
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
 * The ShopRestResponse type specifies the data format used for any response generated by the Yapital Shop API.
 *
 * Fields
 * Element name     Type        Description
 * status           integer     HTTP Status code of the response.
 * code             long        Shop API specific code.
 * message          string      Description of the status. Note: might be empty.
 * payload          anyType     Payload content.
 *
 * @category   Datatype
 * @package    Codex_Yapital_Model_Datatype
 * @copyright  2013 Code-X GmbH
 * @link       http://code-x.de
 * @since      Class available since Release 0.1.0
 */
class Codex_Yapital_Model_Datatype_Shoprestresponse extends Codex_Yapital_Model_Datatype_Abstract
    implements Codex_Yapital_Model_Datatype_Interface
{

    /**
     * @var int
     */
    protected $_code;

    /**
     * @var string
     */
    protected $_message;

    /**
     * @var mixed
     */
    protected $_payload;

    /**
     * @var int
     */
    protected $_status;


    /**
     * @return int
     */
    public function getCode()
    {

        return $this->_code;
    }


    /**
     * Generate array representation of this data type with it's fields and values
     *
     * @return array
     */
    public function getData()
    {
        return array(
            "status"  => $this->getStatus(),
            "code"    => $this->getCode(),
            "message" => $this->getMessage(),
            "payload" => $this->getPayload(),
        );
    }


    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->_message;
    }


    /**
     * @return ArrayObject
     */
    public function getPayload()
    {
        return $this->_payload;
    }


    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->_status;
    }


    /**
     * @param $string string
     */
    public function importRawResponse($string)
    {
        $data = json_decode($string, true);

        $this->setStatus($data["status"]);
        $this->setCode($data["code"]);
        $this->setMessage($data["message"]);
        $this->setPayload($data["payload"]);

        Codex_Yapital_Model_Log::log(
            "Response {$this->getStatus()} (code {$this->getCode()}) for basket {$this->getPayload()->basket_id} "
            . " with transaction {$this->getPayload()->transaction_id}."
        );

        Codex_Yapital_Model_Log::debug($this->getPayload());

        if ($this->isError() || !is_array($data))
        {
            throw new Codex_Yapital_ErrorException("Rest-Request failed: " . $this->getMessage(), $this->getCode());
        }

        return $this;
    }


    public function importZendResponse(Zend_Http_Response $response)
    {
        $body = $response->getBody();
        $this->importRawResponse($body);

        return $this;
    }


    /**
     * Check for errors in response
     *
     * @return bool
     */
    public function isError()
    {
        $status  = $this->getStatus();
        $isError = (
            0 != $this->getCode() // code not zero: so it is not a success
            || substr($status, 0, 1) != 2 // response not 2xx status code: something went wrong
        );

        return $isError;
    }


    /**
     * @param int $code
     *
     * @return $this
     */
    public function setCode($code)
    {

        $this->_code = $code;

        return $this;
    }


    /**
     * @param string $message
     *
     * @return $this
     */
    public function setMessage($message)
    {

        $this->_message = $message;

        return $this;
    }


    /**
     * @param mixed $payload
     *
     * @return $this
     */
    public function setPayload($payload)
    {
        $this->_payload = new ArrayObject((array)$payload, ArrayObject::ARRAY_AS_PROPS);

        return $this;
    }


    /**
     * @param int $status
     *
     * @return $this
     */
    public function setStatus($status)
    {

        $this->_status = $status;

        return $this;
    }
}
