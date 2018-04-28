#### 概要说明
基于ThinkPHP 5.1 框架

POLI AND Paymentexpress

POLI Web Server API 和 PxPay2.0 支付接口，申请后都是在测试环境下集成好，然后，再通过商户在他们的管理后台中去申请。申请通过后，才能在正式交易环境中支付


####使用 pxpay2.0 支付接口

请求参数以：XML格式

请求必带商户信息：PxPay_Userid，PxPay_Key

正式环境API地址：https://sec.paymentexpress.com/pxaccess/pxpay.aspx

测试环境API地址：https://uat.paymentexpress.com/pxaccess/pxpay.aspx


Demo 以及 pxpay2.0 官方封装的类下载地址：

https://www.paymentexpress.com/developer-e-commerce-paymentexpress-hosted-pxpay


测试卡号：https://www.paymentexpress.com/support-merchant-frequently-asked-questions-testing-details

测试环境下，信用卡用户名，过期时间和CVC随便填写

#### POLI V2 支付接口

#POLI Payment

#### 基本认证
基本认证是通过使用 MerchantCode(商家代码)/AuthenticationCode(认证码) 对来唯一且安全地识别POLi商家的手段。 

#### 请求API，
要在POLi中使用基本身份验证，您需要格式化字符串，如下所示：
```
        MerchantCode:AuthenticationCode
        Then Base64 encode it:
        TWVyY2hhbnRDb2RlOkF1dGhlbnRpY2F0aW9uQ29kZQ==
        And put it as the 'Authorization' header, with the word 'Basic' in-front of it:
        Authorization: Basic TWVyY2hhbnRDb2RlOkF1dGhlbnRpY2F0aW9uQ29kZQ==
```

#### 具体PHP请求

```
 $auth = base64_encode('MerchantCode:AuthenticationCode');
 $header = array();
 $header[] = 'Authorization: Basic '.$auth;
```

> 警告：无论何时传送给我们的POLi API，都一定要包含此标题。包含在Header中


#### curl需要用到一个请求包

下载地址：https://raw.githubusercontent.com/bagder/ca-bundle/master/ca-bundle.crt

```
curl_setopt( $ch, CURLOPT_CAINFO, "ca-bundle.crt");

```


#### iBank 测试
在你申请POLI后，他们会发给你们一份文件，里面有相关测试帐号信息
