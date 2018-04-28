#### POLi交易状态
POLi交易状态记录整个付款过程中的交易进度。 每个状态代表了交易中的关键点，并且在客户进入下一个交易并最终完成交易之前，每个状态都必须达到。 
有两类交易状态：

|类型|描述|
|:-----  |:-----|
|Active |在达成终端状态之前在交易过程中获得。 具有活动状态的交易不被视为已完成  |
|Terminal|当交易成功或失败时达成结论|


|状态|类别|描述|
|:-----  |:-----|:-----|
|Initiated| Active|当一个事务开始时，它立即被分配Initiated状态|
|FinancialInstitution Selected|Active|当用户选择他们希望使用的金融机构时，交易进入FinancialInstitutionSelected状态 |
|EULAAccepted|Active|当用户接受POLi最终用户许可协议时，交易进入EULAAccepted|
|InProcess|Active|当客户点击他们选择的银行的登录页面时就会达到此状态|
|Unknown|Active|当用户点击确认按钮进行付款时，交易进入未知状态。 付款的结果正在等待处理|
|Completed|Terminal|网上银行收据由银行签发的成功交易。 POLi系统已经认识到这一点，并通过GETTransaction API通知商家。 预计资金将用于解决这一问题|
|Cancelled|Terminal|当用户取消交易时，它将进入取消状态|
|Failed|Terminal|失败状态发生在事务遇到不可恢复的问题时，例如; 银行特定问题，银行连接丢失或通信错误。 POLi系统当时也可能存在问题|
|ReceiptUnverified|Terminal|当POLi系统无法确认用户的付款是否成功时，达到罕见的状态。 在这种情况下，资金可能已经转移，但用户不会显示POLi或商家的收据。 这种状态可能是由于银行问题或用户本地问题引起的|
|TimedOut|Terminal|当客户在POLi超时之前尚未完成交易并且交易目前未处于“未知”状态时自动获得|
