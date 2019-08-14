<?php

class Codex_Yapital_Adminhtml_Yapital_ConfigController extends Mage_Adminhtml_Controller_Action
{

    public function validateAction ()
    {
        session_write_close();

        Codex_Yapital_Model_Log::log("Validating user given credentials");

        $dataHelper           = Mage::helper('yapital/data');
        $result               = array();
        $result["message"]    = $dataHelper->__('We are sorry! Something went wrong.');
        $result["has_errors"] = true;

        try
        {

            if ( isset( $_REQUEST['shop_id'] ) )
            {
                /**
                 * @var $tokenModel Codex_Yapital_Model_Api_Token
                 */
                $tokenModel = Mage::getModel("yapital/api_token");
                $token      = $tokenModel->getTokenByFullCredentials(
                    $_REQUEST['shop_id'],
                    $_REQUEST['client_id'],
                    $_REQUEST['secret_key']
                );

                if ( "" != $token->getAccessToken() )
                {
                    $result["message"]    = $dataHelper->__(
                        'Congratulations! Store this config to let your customer pay easily with yapital.'
                    );
                    $result["has_errors"] = false;
                }
                else
                {
                    $result["message"] = $dataHelper->__('No access token received');
                }
            }

        }
        catch ( Exception $e )
        {
            $result["message"] = "Error: " . $e->getMessage();
        }

        if (true == $result["has_errors"]) {
            Codex_Yapital_Model_Log::log("Unable to validate user given credentials.");
        }

        $resultJSON = Mage::helper('core')->jsonEncode($result);

        $this->getResponse()->setBody($resultJSON);

    }

    public function validateSandboxAction ()
    {
        session_write_close();

        /** @var $config Codex_Yapital_Model_Config */
        $config = Mage::getSingleton('yapital/config');
        $config->setSandbox( true );

        Codex_Yapital_Model_Log::log("Validating user given credentials");

        $dataHelper           = Mage::helper('yapital/data');
        $result               = array();
        $result["message"]    = $dataHelper->__('We are sorry! Something went wrong.');
        $result["has_errors"] = true;

        try
        {

            if ( isset( $_REQUEST['shop_id'] ) )
            {
                /**
                 * @var $tokenModel Codex_Yapital_Model_Api_Token
                 */
                $tokenModel = Mage::getModel("yapital/api_token");
                $token      = $tokenModel->getTokenByFullCredentials(
                    $_REQUEST['shop_id'],
                    $_REQUEST['client_id'],
                    $_REQUEST['secret_key']
                );

                if ( "" != $token->getAccessToken() )
                {
                    $result["message"]    = $dataHelper->__(
                        'Congratulations! Store this config to let your customer pay easily with yapital.'
                    );
                    $result["has_errors"] = false;
                }
            }

        }
        catch ( Exception $e )
        {
            $result["message"] = "Error: " . $e->getMessage();
        }

        if (true == $result["has_errors"]) {
            Codex_Yapital_Model_Log::log("Unable to validate user given credentials.");
        }

        $resultJSON = Mage::helper('core')->jsonEncode($result);

        $this->getResponse()->setBody($resultJSON);

    }

    public function statusAction ()
    {
        $result = array();

        $result = Mage::helper('core')->jsonEncode($result);
        Mage::app()->getResponse()->setBody($result);
    }
}
