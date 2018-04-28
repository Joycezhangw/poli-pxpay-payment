#### 发起一个交易
以下示例是基于ThinkPHP 5.1 版本开发

#### 请求URL:

#### 请求参数:

|参数名|是否必须|类型|说明|
|:----    |:---|:----- |-----   |
|PxPayUserId |是  |string |商户UID   |
|PxPayKey|是|String|商户KEY|
|TxnType|是|String|Purchase|
|AmountInput|是|Decimal|交易金额|
|CurrencyInput|是|String|货币国际代码，通常是三位字符|
|MerchantReference|是|String|商户交易参考，通常是订单交易订单号，唯一识别，用于交易后通知|
|TxnData1|否|String|商户自定义参数1|
|TxnData2|否|String|商户自定义参数2|
|TxnData3|否|String|商户自定义参数3|
|EmailAddress|否|String|用户支付Email地址|
|TxnId|是|String|好像是唯一id,uniqid('ID')|
|BillingId|否|String|具体作用不理解，好像是比对的账单ID，最好不要提交这个参数|
|EnableAddBillCard|否|int|启用开启添加订单卡|
|UrlSuccess|是|String|交易成功，通知地址|
|UrlFail|是|String|交易失败，通知地址|


```
<GenerateRequest>
<PxPayUserId>SamplePXPayUser</PxPayUserId>
<PxPayKey>cff9bd6b6c7614bec6872182e5f1f5bcc531f1afb744</PxPayKey>
<TxnType>Purchase</TxnType>
<AmountInput>1.00</AmountInput>
<CurrencyInput>NZD</CurrencyInput>
<MerchantReference>Purchase Example</MerchantReference>
<TxnData1>John Doe</TxnData1>
<TxnData2>0211111111</TxnData2>
<TxnData3>98 Anzac Ave, Auckland 1010</TxnData3>
<EmailAddress>samplepxpayuser@paymentexpress.com</EmailAddress>
<TxnId>ABC123</TxnId>
<BillingId>BillingId123xyz</BillingId>
<EnableAddBillCard>1</EnableAddBillCard>
<UrlSuccess>https://www.dpsdemo.com/SandboxSuccess.aspx</UrlSuccess>
<UrlFail>https://www.dpsdemo.com/SandboxSuccess.aspx</UrlFail>
</GenerateRequest>
```

#### 请求示例:
```php
public function dopxpay()
    {
		if(!isset($_POST['Trade_id'])){
			return json(returnFormat(-1,'缺少订单号'));
		}
		if(!isset($_POST['AmountInput'])){
			return json(returnFormat(-1,'缺少订单金额'));
		}
        include Env::get('root_path') . "/pay/pxpay/PxPay_Curl.inc.php";
        $pxpay = new \PxPay_Curl(PXPAY_URL, 'PxPay_Userid', 'PxPay_Key');
        $request = new \PxPayRequest();

        $TxnId = uniqid('ID');
		//BillingId要特别注意，发起交易信息，此字段不要填写，pxpay回复的邮件说：该字段仅用于我们在系统中保存的充值卡。 除非您打算使用匹配的BillingId对已保存的卡进行充电，否则请不要填写此信息。（大概翻译过来的意思）
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
		if($url){
			return json(returnFormat(200, 'success', ['url' => $url, 'valid' => $valid]));
		}else{
			return json(returnFormat(-1, 'error'));
		}
    }

```

#### 返回示例

```
<Request valid="1">
<URI>https://sec.paymentexpress.com/pxmi3/EF4054F622D6C4C1B4F
9AEA59DC91CAD3654CD60ED7ED04110CBC402959AC7CF035878AE</URI>
</Request>
```

#### 返回参数说明:

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|URI |String   |信用卡支付连接  |

#### 响应代码

|代码|说明|
|:-----  |-----  |
|RC |用户已取消（客户可能已明确取消了Account2Account托管付款页面中的交易）。 |
|51 |客户（付款人）银行账户中的资金可能不足（或由于银行账户问题导致付款失败）。|
|U9 |上行链路超时。 注：如果客户尝试在付款确认阶段提交，可能会发生付款。 请联系支持团队。|
|NY|上行链路连接错误或上行链路可能处于脱机状态。 注：如果客户尝试在付款确认阶段提交，可能会发生付款。|
|EN|用户超时（付款人可能在银行账户登录或银行账户选择阶段放弃）注意：但是没有发生付款|
|G3|帐户验证期间的用户取消。|
|GN|付款超时。|
