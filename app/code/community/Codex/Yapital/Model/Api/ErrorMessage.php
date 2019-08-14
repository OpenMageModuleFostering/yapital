<?php

/**
 * Created by PhpStorm.
 * User: mike
 * Date: 2/19/14
 * Time: 12:09 AM
 */
class Codex_Yapital_Model_Api_ErrorMessage extends Varien_Object
{
    public function __construct()
    {
        $this->setData(
            array(
                // HTTP 400s
                400102 => "Request not readable.",
                400004 => "Invalid item price.",

                // HTTP 403
                403001 => "Access denied.",
                403009 => "Duplicate entry found.",
                403999 => "Operation not allowed. Please contact the Yapital Customer Service Center at 00800-927 927 10.",

                // HTTP 404
                432100 => "The requested resource is not available.",

                // HTTP 500
                // 432100 =>
            )
        );
    }
} 
