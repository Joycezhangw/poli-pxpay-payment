<?php
/**
 * 支付
 * User: Administrator
 * Date: 2018/4/24
 * Time: 14:42
 */

namespace app\index\controller;


use think\facade\Env;

class Pay extends BaseController
{
    protected $_baseUrl = 'http://www.domain.co.nz/index/';

    /**
     * Payment Checkout
     * pxPay2.0
     * @return \think\response\Json
     */
    public function dopxpay()
    {
        if (!isset($_POST['Trade_id'])) {
            return json(returnFormat(-1, '缺少订单号'));
        }
        if (!isset($_POST['AmountInput'])) {
            return json(returnFormat(-1, '缺少订单金额'));
        }
        include Env::get('root_path') . "/pay/pxpay/PxPay_Curl.inc.php";
        $pxpay = new \PxPay_Curl(PXPAY_URL, PXPAY_USER_ID, PXPAY_KEY);
        $request = new \PxPayRequest();

        $TxnId = uniqid('ID');

        //$request->setBillingId($_POST['Trade_id']);
        $request->setMerchantReference($_POST['Trade_id']);
        $request->setAmountInput($_POST['AmountInput']);
        $request->setTxnData1($_POST['user_id']);
        $request->setTxnType('Purchase');
        $request->setCurrencyInput($_POST['CurrencyInput']);
        $request->setUrlFail($this->_baseUrl . 'pxpay/notifyurl');
        $request->setUrlSuccess($this->_baseUrl . 'pxpay/returnurl');
        $request->setTxnId($TxnId);


        $request_string = $pxpay->makeRequest($request);
        $response = new \MifMessage($request_string);
        //得到pxpay支付页面
        $url = $response->get_element_text("URI");
        $valid = $response->get_attribute("valid");
        if ($url) {
            return json(returnFormat(200, 'success', ['url' => $url, 'valid' => $valid]));
        } else {
            return json(returnFormat(-1, 'error'));
        }
    }

    public function dopoli()
    {
        if (!isset($_POST['Trade_id'])) {
            return json(returnFormat(-1, '缺少订单号'));
        }
        if (!isset($_POST['AmountInput'])) {
            return json(returnFormat(-1, '缺少订单金额'));
        }
        $data = [
            "Amount" => $_POST['AmountInput'],
            "CurrencyCode" => $_POST['CurrencyInput'],//"NZD",
            "MerchantReference" => $_POST['Trade_id'],
            "MerchantHomepageURL" => $this->_baseUrl,
            "SuccessURL" => $this->_baseUrl . 'poli/returnurl',
            "FailureURL" => $this->_baseUrl . 'poli/notifyurl',
            "CancellationURL" => $this->_baseUrl . 'poli/notifyurl',
            "NotificationURL" => $this->_baseUrl . 'poli/returnurl'
        ];
        include Env::get('root_path') . "/pay/poli/Polipay.php";
        $poli = new \Polipay();

        $res = $poli->doInitiateTransaction($data);

        return json($res);
    }
}