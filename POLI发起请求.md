#### 简要描述：

- 发起交易

#### 请求URL:

- https://poliapi.apac.paywithpoli.com/api/v2/Transaction/Initiate

#### 请求方式：

- POST

#### 请求头：

|参数名|是否必须|类型|说明|
|:----    |:---|:----- |-----   |
|Authorization: Basic |是  |string | 请求内容签名( MerchantCode:AuthenticationCode) 商户代码:认证代码   |

#### 请求示例:

```php
$json_builder = '{
    "Amount":"1.2",
    "CurrencyCode":"AUD",
    "MerchantReference":"CustomerRef12345",
    "MerchantHomepageURL":"https://www.mycompany.com",
    "SuccessURL":"https://www.mycompany.com/Success",
    "FailureURL":"https://www.mycompany.com/Failure",
    "CancellationURL":"https://www.mycompany.com/Cancelled",
    "NotificationURL":"https://www.mycompany.com/nudge" 
}';
 
$auth = base64_encode('S61xxxxx:AuthCode123');
$header = array();
$header[] = 'Content-Type: application/json';
$header[] = 'Authorization: Basic '.$auth;
 
$ch = curl_init("https://poliapi.apac.paywithpoli.com/api/v2/Transaction/Initiate");
//See the cURL documentation for more information: http://curl.haxx.se/docs/sslcerts.html
//We recommend using this bundle: https://raw.githubusercontent.com/bagder/ca-bundle/master/ca-bundle.crt
curl_setopt( $ch, CURLOPT_CAINFO, "ca-bundle.crt");
curl_setopt( $ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
curl_setopt( $ch, CURLOPT_HTTPHEADER, $header);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_builder);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec( $ch );
curl_close ($ch);
 
$json = json_decode($response, true);
 
header('Location: '.$json["NavigateURL"]);
```

#### 返回示例:

#### 请求参数:

|参数名|是否必须|类型|说明|
|:----    |:---|:----- |-----   |
|Amount |是  |Decimal |支付金额   |
|CurrencyCode |是  |String/Text(通常3个字符) | 国际货币代码    |
|MerchantReference|是|String|由商家为交易指定的唯一参考,比如订单号，最好不要有特殊字符，最多100个字符|
|MerchantReferenceFormat|否|String（用于NZ对帐。 最多50个字符）|用于指定新西兰对帐格式。 请参阅NZReconciliation了解更多详情|
|MerchantData|否|String|该字段用于商户交易参考,商户指定的信息与交易一起进行，供商户内部使用，交易后。 2000个字符|
|MerchantHomepageURL|是|String|显示在POLi着陆页面上。 最多1000个字符,完整的商家URL显示在POLi登录页面上的商户信息中|
|SuccessURL|是|String|	如果交易成功，则将完整的URL重定向到客户，如果URL中没有查询字符串，则将事务标记添加为查询参数。 如果指定的URL有单个/多个查询字符串，则POLi会自动将查询参数附加到查询参数。最多1000个字符|
|FailureURL|否|String|如果交易不成功，则将完整的URL重定向到客户，如果URL中没有查询字符串，则将事务标记添加为查询参数。 如果指定的URL有单个/多个查询字符串，则POLi会自动将查询参数附加到查询参数。最多1000个字符|
|CancellationURL|否|String|	完整的URL用于在客户取消交易时重定向客户。如果URL中没有查询字符串，则将事务标记添加为查询参数。 如果指定的URL有单个/多个查询字符串，则POLi会自动将查询参数附加到查询参数。最多1000个字符|
|NotificationURL|否|String|	POLi将提供Nudge POST的完整URL，当交易达到终端状态时，POLi将向该位置发布'微动'。确保您的端点支持HTTP POST。最多1000个字符|
|Timeout|否|String|默认900，事务超时之前的秒数，以秒为单位的交易超时，默认为900（15分钟）|
|SelectedFICode|否|String|用于预选银行以跳过POLi登录页面，表示客户将支付的FI的字符串|

#### 返回示例:

**正确时返回:**

```
{
    "Success": true,
    "NavigateURL": "https://txn.apac.paywithpoli.com/?Token=uo3K8YA7",
    "ErrorCode": 0,
    "ErrorMessage": null,
    "TransactionRefNo": "996117408041"
}
```


#### 返回参数说明:

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|Success |Boolean   |表示成功，true or false  |
|TransactionRefNo |String   |POLi交易的唯一12位数字参考。  |
|NavigateURL |String   |POLI登录页面的有效URL附加了包含事务标记的查询字符串。 例如：澳大利亚/新西兰：https：//txn.apac.paywithpoli.com/？token = [token]  |
|ErrorCode |Integer   |一个错误代码，如果有的话（如果没有则为O）  |
|ErrorMessage |String   |	包含有关错误详细信息的字符串  |
