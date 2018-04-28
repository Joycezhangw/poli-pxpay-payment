#### 简要描述：

- 获取交易的状态和详细信息

#### 接口版本：

|版本号|制定人|制定日期|修订日期|
|:----    |:---|:----- |-----   |
|v2 |POLI  |2017-03-20 |  2018-04-28 |

#### 请求URL:

- https://poliapi.apac.paywithpoli.com/api/v2/Transaction/GetTransaction?token=$token

#### 请求方式：

- GET
- POST

#### 请求头：

|参数名|是否必须|类型|说明|
|:----    |:---|:----- |-----   |
|Authorization: Basic |是  |string | 请求内容签名( MerchantCode:AuthenticationCode) 商户代码:认证代码   |



#### 请求参数:

|参数名|是否必须|类型|说明|
|:----    |:---|:----- |-----   |
|token |是  |string |支付请求返回的token   |

#### 请求示例:

```php
$token = $_POST["Token"];
if(is_null($token)) {
	$token = $_GET["token"];
}
 
 $auth = base64_encode('S61xxxxx:AuthCode1234');
 $header = array();
 $header[] = 'Authorization: Basic '.$auth;
 
 $ch = curl_init("https://poliapi.apac.paywithpoli.com/api/v2/Transaction/GetTransaction?token=".urlencode($token));
 //See the cURL documentation for more information: http://curl.haxx.se/docs/sslcerts.html
 //We recommend using this bundle: https://raw.githubusercontent.com/bagder/ca-bundle/master/ca-bundle.crt
 curl_setopt( $ch, CURLOPT_CAINFO, "ca-bundle.crt");
 curl_setopt( $ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
 curl_setopt( $ch, CURLOPT_HTTPHEADER, $header);
 curl_setopt( $ch, CURLOPT_HEADER, 0);
 curl_setopt( $ch, CURLOPT_POST, 0);
 curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 0);
 curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
 $response = curl_exec( $ch );
 curl_close ($ch);
 
 $json = json_decode($response, true);
 
 print_r($json);
```

#### 返回示例:

**正确时返回(及说明):**


```
{
    "CountryName":"New Zealand",//国家名称
    "FinancialInstitutionCountryCode":"iBankNZ01",//金融机构国家代码
    "TransactionID":"8e4b1f76-c3cd-4a942bab4eaa",//poli交易单号
    "MerchantEstablishedDateTime":"2018-04-28T12:44:10.19",//商家发起的交易时间
    "PayerAccountNumber":"1238364",//付款人帐号
    "PayerAccountSortCode":"123456",//付款人账户分类码
    "MerchantAccountSortCode":"123456",//商家帐户分类代码
    "MerchantAccountName":"123456 Newwork",//商家账户名
    "MerchantData":"",//商家提交的数据
    "CurrencyName":"New Zealand Dollar",//货币名称
    "TransactionStatus":"Completed",//交易状态，Completed-已完成
    "IsExpired":false,//是否过期
    "MerchantEntityID":"48cf3193-12345-1d80127e864d",//商家实体ID
    "UserIPAddress":"127.0.0.1",//用户IP地址
    "POLiVersionCode":"4 ",//POLI版本代码
    "MerchantName":"123456",//商家名称
    "TransactionRefNo":"123456",//交易参考编码
    "CurrencyCode":"NZD",//货币国际代码
    "CountryCode":"NZ",//国家代码
    "PaymentAmount":1,//实际支付金额
    "AmountPaid":1,//支付金额
    "EstablishedDateTime":"2018-04-28T12:44:10.203",//建立时间
    "StartDateTime":"2018-04-28T12:44:10.203",//交易开始时间
    "EndDateTime":"2018-04-28T12:56:27.14",//交易结束时间
    "BankReceipt":"123456-292583",//银行单据
    "BankReceiptDateTime":"28 April 2018 12:56:27",//银行收款日期时间
    "TransactionStatusCode":"Completed",//银行交易状态吗
    "ErrorCode":null,//错误代码
    "ErrorMessage":"",//错误信息
    "FinancialInstitutionCode":"iBankNZ01",//金融机构代码
    "FinancialInstitutionName":"iBank NZ 01",//金融机构名称
    "MerchantReference":"U20180428093258261",//商家提供参考信息，这里是订单支付ID
    "MerchantAccountSuffix":"000",//商家账户后缀
    "MerchantAccountNumber":"0896327",//商家帐号
    "PayerFirstName":"Mr",//付款人名字
    "PayerFamilyName":"DemoShopper",//付款人姓氏
    "PayerAccountSuffix":""//付款人账户后缀
}
```


