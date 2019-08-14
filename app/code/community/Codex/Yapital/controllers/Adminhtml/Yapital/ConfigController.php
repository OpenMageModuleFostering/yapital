<?php

class Codex_Yapital_Adminhtml_Yapital_ConfigController extends Mage_Adminhtml_Controller_Action
{

    public function preDispatch()
    {
        /** @var $config Codex_Yapital_Model_Config */
        $config = Mage::getSingleton('yapital/config');

        if ($this->getRequest()->getParam('sandbox', false))
        {
            $config->setSandbox(true);
        } else {
            $config->setSandbox(false);
        }
        parent::preDispatch();
    }

    public function statusAction()
    {
        $result = array();

        $result = Mage::helper('core')->jsonEncode($result);
        Mage::app()->getResponse()->setBody($result);
    }

    public function updateAction()
    {
        Codex_Yapital_Model_Log::log("Updating transactions");

        /** @var Mage_Captcha_Helper_Data $coreHelper */
        $coreHelper = Mage::helper('core');

        $config = Mage::getModel('yapital/config');

        $refreshFrom = date('Y-m-d', strtotime("today -1 week"));

        try {
            /** @var $restClient Codex_Yapital_Model_Api_Connection */
            $restClient = Mage::getModel('yapital/api_connection', $config->getApiUrl());
            $result = $restClient->restGet(
                $config->getApiUrlPath() .
                sprintf('/shops/%s/transactions', $config->getYapitalShopId()),
                array(
                    'from' => $refreshFrom,
                    'until' => date("Y-m-d", strtotime("today +1 day"))
                )
            );

            $updatedTransactions = 0;
            $transactions = $coreHelper->jsonDecode($result->getBody(), Zend_Json::TYPE_OBJECT);

            if (!empty($transactions->error)) {
                throw new Exception('API Exception: '.$transactions->error_description);
            }

            $order = Mage::getModel('sales/order');
            foreach ($transactions->payload->transaction as $transaction) {
                if ($transaction->transaction_status == Codex_Yapital_Model_Datatype_TransactionStatus::PAID) {
                    $order->load($transaction->order_number, 'increment_id');

                    if ($order->getId() && $config->getOrderPaidState() != $order->getStatus()) {

                        /** @var $orderTransaction Codex_Yapital_Model_Order_Transaction */
                        $orderTransaction = Mage::getModel('yapital/order_transaction');
                        $orderTransaction->load($transaction->transaction_id, 'transaction_id');
                        if ($orderTransaction->getId() && $orderTransaction->getOrderId() == $order->getId()) {

                            /* @var $notification Codex_Yapital_Model_Notification */
                            $notification = Mage::getModel('yapital/notification');
                            $notification->setData( array(
                                'notification_id' => null,
                                'transaction_id' => $transaction->transaction_id,
                                'status_code' => $transaction->transaction_status,
                                'status_information' => null,
                                'customer_data' => null,
                                'amount' => $transaction->total_amount,
                                'currency' => $transaction->currency,
                            ));

                            $notification->processOrder();

                            $updatedTransactions++;
                            Codex_Yapital_Model_Log::log("Order #".$order->getId() ." updated.");
                        }
                    }
                }
            }

            $this->getResponse()->setBody(
                $coreHelper->jsonEncode(
                    array(
                        'success' => true,
                        'updated' => $updatedTransactions,
                        'from' => $refreshFrom,
                        'message' => Mage::helper('yapital')->__('%s transaction successfully updated.', $updatedTransactions)
                ))
            );
        } catch (Exception $e) {

            Codex_Yapital_Model_Log::log('Exception '.$e->getMessage());

            $this->getResponse()->setBody(
                $coreHelper->jsonEncode(
                    array(
                        'success' => false,
                        'from' => $refreshFrom,
                        'message' => Mage::helper('yapital')->__('We are sorry! Something went wrong.')
                    ))
            );

        }

        return;
    }

    public function validateAction()
    {
        session_write_close();

        Codex_Yapital_Model_Log::log("Validating user given credentials");

        $dataHelper           = Mage::helper('yapital');
        $result               = array();
        $result["message"]    = $dataHelper->__('We are sorry! Something went wrong.');
        $result["has_errors"] = true;

        try
        {

            if (isset($_REQUEST['shop_id']))
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

                if ("" != $token->getAccessToken())
                {
                    $result["message"]    = $dataHelper->__(
                        'Congratulations! Store this config to let your customer pay easily with yapital.'
                    );
                    $result["has_errors"] = false;
                }
                else
                {
                    $result["message"] = $dataHelper->__(
                        'No access token received. Please check your credentials'
                    );
                }
            }

        } catch (Exception $e)
        {
            $result["message"] = "Error: " . $e->getMessage();
        }

        if (true == $result["has_errors"])
        {
            Codex_Yapital_Model_Log::debug( $result['message'] );
            Codex_Yapital_Model_Log::log("Unable to validate user given credentials.");
        }

        $resultJSON = Mage::helper('core')->jsonEncode($result);

        $this->getResponse()->setBody($resultJSON);

    }

}
