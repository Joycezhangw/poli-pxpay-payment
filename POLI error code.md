#### 常见错误
在任何类型的失败请求中，您将收到错误代码。 这些分为两类，并在下表中解释： 

#### 商家常见错误

|错误代码|错误名称|描述|
|:-----  |:-----|-----                           |
|1001 |	Invalid token(令牌无效)   |令牌不对应于POLi ID。 这可能是由于令牌不正确或包含编码字符  |
|1003|Invalid merchant code(商家代码无效)	|您在初始交易请求中规定的商家代码不正确|
|1004|Inactive merchant(代码商家)	|该请求中指定的商家代码对应于不活动的商家|
|1005|Merchant not authenticated(商家未通过身份验证)	|请检查您是否已为商家代码输入正确的验证码。 如果您确定拥有，请联系POLi服务台|
|1011/14053|Merchant per transaction limit exceeded(商家每笔交易限额已超出)	|指定货币的付款金额已超过商家对该币种的每笔交易限额|
|1012/14054|Merchant daily transaction limit exceeded(商家每日交易限额超出)|指定货币的付款金额已超过商家对该币种的每日交易限额|
|1025/14058|Invalid Specified Amount(无效的指定金额)|交易不能在1.00美元以下开始|
|1014|Invalid URL format in Initiate Transaction(启动事务中的URL格式无效)|指定网址的格式无效。 请检查您的初始交易数据中的URL字段，并确保它们是正确的|
|1022|Mandatory field is missing(必填字段丢失)|发起事务请求中的必填字段缺失|
|1024|Invalid currency format(货币格式无效)|金额格式不正确。请确保指定的数量不超过2位小数|
|3007|Invalid transaction status(无效的交易状态)|后端异常导致事务失败。这可能是由响应超时或因数据损坏或无效造成的异常造成的|
|4032|Unhandled exception(未处理的异常)|POLi预期的数据尚未由金融机构返还。这可能是由于意外或更改的银行页面或系统超时。|
|4033|Unhandled HttpRequestException(未处理的HttpRequestException)|金融机构的回应无效或缺失。这可能表示最终用户或银行的网络连接问题，或者银行正在经历停机|
|4034|JavaScript execution failed(JavaScript执行失败)|POLi预期的数据尚未由金融机构返还。这可能是由于意外或变更的银行页面，或银行正在经历停机。|
|11002|Problem delivering nudge to merchant(向商家推送问题)|Nudge通知URL可能是公开无法访问，配置错误，或目的地已关闭或响应时间过长|
|14104|	POLi Link has expired(POLi Link已过期)|您的POLi链接已过期或POLi链接的过期日期已设置|
|14151|POLi Link has been fully paid(POLi Link已全额付款)|此POLi链接已全额付款|

#### 银行/最终用户常见错误

|错误代码|错误名称|描述|
|:-----  |:-----|-----                           |
|4001 |	Unknown error (related to bank or merchant)(未知错误（与银行或商家有关） |由于银行或商户POLi账户的技术问题，POLi无法继续。 您可能想重试，如果错误仍然存​​在，请联系您正在付款的商家|
|4005|Unexpected bank page(意外的银行页面)	|POLi遇到了意想不到的银行页面。 这可能是由于新的或更改的银行页面。 我们的支持团队已被告知错误，并会尽快解决此错误|
|4040|Blacklisted Payer account(列入黑名单的付款人帐户)	|付款人银行帐户在POLi系统中被列入黑名单|
|4051|Payer Internet Banking locked(付款人网上银行被锁定)	|您的网上银行服务已锁定。 请联系您的银行了解更多详情|
|4052|Third-party payments not supported from payers bank account(第三方付款不支持付款人银行帐户)	|您的银行帐户可能需要支付任何功能或启用了安全措施。 请联系您的银行了解更多详情|
|4054|	Multiple sessions detected(检测到多个会话)|检测到多个网上银行会话。 请退出您的网上银行会话，取消此付款并重试您的付款|
|4055|No valid accounts(没有有效的帐户)|POLi服务不支持您的帐户。 通常情况下，您需要一个个人银行账户，可以向任何人付款以使用该服务。 请与您的银行联系以获得进一步帮助|
|4056|Bank unavailable(银行不可用)|所选银行目前不可用; 请稍后再试|
|4057|Multiple signatories are not supported(不支持多个签名)|POLi无法支持需要多个签名人单独授权的帐户; 请使用其他帐户或个人网上银行档案重试您的POLi付款|
|4058|Bank account daily transaction limit has been exceeded(银行账户每日交易限额已超过)|该交易将超过您银行帐户的每日支付限额。 请联系您的银行以增加您的限额|
|4059|Bank Session Error(银行会话错误)|您的银行会话由于银行错误或会话超时而结束。 请重试您的付款|
|4060|Bank account second factor security locked/suspended(银行账户第二因素安全锁定/暂停)|第二因素身份验证输入错误，不可用或已被暂停。 请与您的银行联系以获得进一步帮助|
|4061|Bank second factor security issue(银行第二因素安全问题)|第二因素身份验证可能需要在您的银行账户上设置或目前不可用。 请与您的银行联系以获得进一步帮助|
|6010|Users browser/system unsupported(用户浏览器/系统不受支持)|	付款人的浏览器/系统很可能是旧的并且不兼容。 用户需要在备用设备上重试付款|
