<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/23
 * Time: 12:02
 */

namespace app\index\controller;


use think\Controller;
use think\Log;

class BaseController extends Controller
{
    protected $_appKey = '1ZXXXX4bL';
    protected $_appId = 105;

    public function __construct()
    {
        if ((isset($_POST['token'])) && isset($_POST['app_id']) && $_POST['app_id']) {
            $data = $_POST;
            $checkret = $this->doCheckUrlWithEncrypt($this->_appKey, $data);
            if (!$checkret) {
                echo json_encode(returnFormat(-1, 'API接口有误,请确保APP KEY及APP ID正确'));
                exit();
            }
        } else {
            echo json_encode(returnFormat(-1, 'API接口有误,请确保APP KEY及APP ID正确'));
            exit();
        }
    }


    private function doCheckUrlWithEncrypt($key, $formValue = [])
    {

        \think\facade\Log::write($formValue, 'info');

        $token = $formValue['token'];
        unset($formValue['token']);

        $hash_row = $formValue;
        array_multiksort($hash_row, SORT_STRING);

        $hash_row['key'] = $key;
        $tmp_str = http_build_query($hash_row);

        \think\facade\Log::write('$tmp_str:' . $tmp_str, 'info');
        \think\facade\Log::write('md5-key:' . md5($tmp_str), 'info');

        //可以判断请求时间是否超过某个期限, 1分钟内
        if ((get_time() - $hash_row['rtime'] < 6000) && $token == md5($tmp_str)) {
            return true;
        } else {
            return false;
        }
    }

}