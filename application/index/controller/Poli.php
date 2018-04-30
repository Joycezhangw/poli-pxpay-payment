<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/28
 * Time: 10:27
 */

namespace app\index\controller;


use think\Controller;
use think\facade\Env;

class Poli extends Controller
{
    public function returnurl()
    {
		$token = isset($_POST["Token"]) ? $_POST["Token"] : null ;
		if(is_null($token)) {
			$token = $_GET["token"];
		}
        include Env::get('root_path') . "/pay/poli/Polipay.php";
        $poli = new \Polipay();

        $res = $poli->getTransaction($token);
		if($res['ErrorCode']==null){
			//成功
			if ($res['TransactionStatusCode'] == "Completed") {
				$data = [
					'order_id' => $res['MerchantReference'],
					'buyer_id' => 0
				];
				$res = request_post(PAY_BASE_URL . 'paycenter/api/payment/pxpay/return_url.php', $data);
			} else {
				$res = request_post(PAY_BASE_URL . 'paycenter/api/payment/pxpay/notify_url.php');
			}
			if ($res) {
				header("Location: " . $res);
			}else{
				echo('网络繁忙，请稍后再试');
			}
			exit();
		}else{
			$res = request_post(PAY_BASE_URL . 'paycenter/api/payment/pxpay/notify_url.php', ['time' => time()]);
			if ($res) {
				header("Location: " . $res);
			} else {
				echo('网络繁忙，请稍后再试');
			}
			die();
		}
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