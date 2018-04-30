<?php
/**
 * POLI payment 支付请求
 * User: Administrator
 * Date: 2018/4/16
 * Time: 17:30
 */

class Polipay
{
    /**
     * @var string 认证码，注册POLI payment后，由poli提供
     */
    private $_authCode = 'AuthenticationCode';
    /**
     * @var string 商家代码，注册POLI payment后，由poli提供
     */
    private $_mechantCode = 'MerchantCode';
    /**
     * @var string 支付币种，注册POLI时，我们所选择的支付国际货币代码，这里时新西兰纽币
     */
    private $_currencyCode = 'NZD';
    /**
     * @var string POLI payment WebService URL
     */
    private $_poliBaseApiUrl = 'https://poliapi.apac.paywithpoli.com/api/v2/Transaction/';


    /**
     * 发起交易
     * @param array $params
     * @return mixed
     */
    public function doInitiateTransaction(array $params)
    {
        $param = json_encode($params);
        $auth = base64_encode($this->_mechantCode . ':' . $this->_authCode);
        $header = array();
        $header[] = 'Content-Type: application/json';
        $header[] = 'Authorization: Basic ' . $auth;

        $ch = curl_init($this->_poliBaseApiUrl . "Initiate");
        curl_setopt($ch, CURLOPT_CAINFO, \think\facade\Env::get('root_path') . "pay/poli/ca-bundle.crt");
        curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        \think\facade\Log::write($response, 'info');
        $json = json_decode($response, true);
        return $json;
    }

    /**
     * 获取交易状态
     * @param string $token  交易成功获取道的 token
     * @return mixed
     */
    public function getTransaction($token)
    {
        $auth = base64_encode($this->_mechantCode . ':' . $this->_authCode);
        $header = array();
        $header[] = 'Authorization: Basic ' . $auth;

        $ch = curl_init($this->_poliBaseApiUrl . "GetTransaction?token=" . urlencode($token));
        curl_setopt($ch, CURLOPT_CAINFO, \think\facade\Env::get('root_path') . "pay/poli/ca-bundle.crt");
        curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        \think\facade\Log::write($response, 'info');
        $json = json_decode($response, true);
        return $json;
    }

}