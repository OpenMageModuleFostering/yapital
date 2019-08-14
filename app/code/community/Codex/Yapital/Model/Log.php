<?php
/**
 * Delivers a log that is used in the Yapital API
 *
 *
 * PHP version 5
 *
 *
 * @category   Yapital
 * @package    Codex_Yapital_Model
 * @copyright  2013 Code-X GmbH
 * @link       http://code-x.de
 * @since      File available since Release 0.1.0
 */

/**
 * The Log stores system messages to Magento
 *
 * @category   Yapital
 * @package    Codex_Yapital_Model
 * @copyright  2013 Code-X GmbH
 * @link       http://code-x.de
 * @since      Class available since Release 0.1.0
 */
class Codex_Yapital_Model_Log
{

    public static $isDebugMode = true;

    public static $isVerboseMode = true;

    /**
     * Decide when to print the error message (true) or not (false)
     * @var bool
     */
    protected static $_print = false;


    /**
     * Send a debug message to the log
     *
     * @param string $message
     */
    public static function debug($message = "~~~")
    {
        if (static::$isDebugMode)
        {
            if (!is_scalar($message))
            {
                $message = var_export($message, true);
            }

            self::_logAdapter($message, Zend_Log::DEBUG);
        }
    }


    /**
     * Send an error message to the log
     *
     * @param $message
     */
    public static function error($message)
    {
        $message = "ERROR! " . $message;
        self::_logAdapter($message, Zend_Log::WARN);
    }


    /**
     * Send a message to log
     *
     * @param $message
     */
    public static function log($message)
    {
        self::_logAdapter($message, Zend_Log::INFO);
    }


    public static function setPrint($bool = true)
    {
        self::$_print = $bool;
    }


    public static function verbose($message)
    {
        if (static::$isVerboseMode)
        {
            self::_logAdapter($message, Zend_Log::NOTICE);
        }
    }


    protected static function _logAdapter($message, $level = null, $file = 'codex_yapital.log', $forceLog = false)
    {
        static $firstInit = true;

        if ($firstInit)
        {
            $firstInit = false;
            Mage::log('-------------', Zend_Log::INFO, $file, $forceLog);
        }

        $message = sprintf(
	        "Yapital (%s): %s",
	        getmypid(),
	        $message
        );

        if (self::$_print)
        {
            echo "\n" . $message . "\n";
        }
        Mage::log($message, $level, $file, $forceLog);
    }
}
