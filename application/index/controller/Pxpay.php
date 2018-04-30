<?php
/**
 * pxPay2.0 回调
 * User: Administrator
 * Date: 2018/4/17
 * Time: 9:38
 */

namespace app\index\controller;


use think\facade\Env;

class Pxpay
{

    public function returnurl()
    {
        include Env::get('root_path') . "/pay/pxpay/PxPay_Curl.inc.php";
        $pxpay = new \PxPay_Curl(PXPAY_URL, PXPAY_USER_ID, PXPAY_KEY);
        if (isset($_REQUEST["result"])) {
            $enc_hex = $_REQUEST["result"];
            $rsp = $pxpay->getResponse($enc_hex);

            $Success = $rsp->getSuccess();   # =1 when request succeeds
            $AmountSettlement = $rsp->getAmountSettlement();
            $AuthCode = $rsp->getAuthCode();  # from bank
            $CardName = $rsp->getCardName();  # e.g. "Visa"
            $CardNumber = $rsp->getCardNumber(); # Truncated card number
            $DateExpiry = $rsp->getDateExpiry(); # in mmyy format
            $DpsBillingId = $rsp->getDpsBillingId();
            $BillingId = $rsp->getBillingId();
            $CardHolderName = $rsp->getCardHolderName();
            $DpsTxnRef = $rsp->getDpsTxnRef();
            $TxnType = $rsp->getTxnType();
            $TxnData1 = $rsp->getTxnData1();
            $TxnData2 = $rsp->getTxnData2();
            $TxnData3 = $rsp->getTxnData3();
            $CurrencySettlement = $rsp->getCurrencySettlement();
            $ClientInfo = $rsp->getClientInfo(); # The IP address of the user who submitted the transaction
            $TxnId = $rsp->getTxnId();
            $CurrencyInput = $rsp->getCurrencyInput();
            $EmailAddress = $rsp->getEmailAddress();
            $MerchantReference = $rsp->getMerchantReference();
            $ResponseText = $rsp->getResponseText();
            $TxnMac = $rsp->getTxnMac(); # An indication as to the uniqueness of a card used in relation to others

            //成功
            if ($rsp->getSuccess() == "1") {
                $data = [
                    'order_id' => $MerchantReference,
                    'buyer_id' => $TxnData1
                ];
                $res = request_post(PAY_BASE_URL . 'paycenter/api/payment/pxpay/return_url.php', $data);

            } else {
                $res = request_post(PAY_BASE_URL . 'paycenter/api/payment/pxpay/notify_url.php');

            }
        } else {
            $res = request_post(PAY_BASE_URL . 'paycenter/api/payment/pxpay/notify_url.php');
        }
        if ($res) {
            header("Location: " . $res);
        } else {
            echo('网络繁忙，请稍后再试');
        }
        exit();
    }

    public function notifyurl()
    {
        $res = request_post(PAY_BASE_URL . 'paycenter/api/payment/pxpay/notify_url.php', ['time' => time()]);
        if ($res) {
            header("Location: " . $res);
        } else {
            echo('网络繁忙，请稍后再试');
        }
        die();
    }


}