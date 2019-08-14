<?php
/**
 * Defines the Token datatype for the Yapital API used (only) by the plugin
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
 * The Token type specifies the information about the received tokens
 *
 * Note: Not part of the specification. Only used in this plugin.
 *
 * @category   Datatype
 * @package    Codex_Yapital_Model_Datatype
 * @copyright  2013 Code-X GmbH
 * @link       http://code-x.de
 * @since      Class available since Release 0.1.0
 */
class Codex_Yapital_Model_Datatype_Token extends Codex_Yapital_Model_Datatype_Abstract
    implements Codex_Yapital_Model_Datatype_Interface
{

    /**
     * @var string
     */
    protected $_accessToken;

    /**
     * @var string
     */
    protected $_tokenType;

    /**
     * @var int
     */
    protected $_expiresIn;

    /**
     * @param string $accessToken
     */
    public function setAccessToken ( $accessToken )
    {

        $this->_accessToken = $accessToken;
    }

    /**
     * @return string
     */
    public function getAccessToken ()
    {

        return $this->_accessToken;
    }

    /**
     * @param int $expiresIn
     */
    public function setExpiresIn ( $expiresIn )
    {

        $this->_expiresIn = $expiresIn;
    }

    /**
     * @return int
     */
    public function getExpiresIn ()
    {

        return $this->_expiresIn;
    }

    /**
     * @param string $tokenType
     */
    public function setTokenType ( $tokenType )
    {

        $this->_tokenType = $tokenType;
    }

    /**
     * @return string
     */
    public function getTokenType ()
    {

        return $this->_tokenType;
    }

    /**
     * @param array $associativeArray
     */
    public function importArray ( $associativeArray )
    {
        $this->setAccessToken($associativeArray["access_token"]);
        $this->setTokenType($associativeArray["token_type"]);
        $this->setExpiresIn($associativeArray["expires_in"]);
    }


    public function getData ()
    {
        return array(
            "access_token" => $this->getAccessToken(),
            "token_type"   => $this->getTokenType(),
            "expires_in"   => $this->getExpiresIn(),
        );
    }
}
