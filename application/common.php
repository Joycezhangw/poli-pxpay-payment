<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
define('PAY_BASE_URL', 'http://XXXXXXXXXXXXXXXXXXXXXXXXXx.cn/');
//PxPay 2.0 支付接口
define('PXPAY_URL', 'https://uat.paymentexpress.com/pxaccess/pxpay.aspx');
define('PXPAY_USER_ID','YouPxPay_Dev');
define('PXPAY_KEY','d07fa29e79XXXXXXXXXXXXXXXXXXXXXXXXXXXXX9aec');

function returnFormat($code, $msg, $data = [])
{
    $arr['status'] = $code;
    $arr['msg'] = $msg ? $msg : '服务器繁忙，请稍后再试！';
    if ($data)
        $arr['data'] = $data;
    return $arr;
}

/**
 * 发起HTTPS请求
 */
function curl_post($url, $data, $header, $post = 1)
{
    //初始化curl
    $ch = curl_init();
    //参数设置
    $res = curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_POST, $post);
    if ($post) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    $result = curl_exec($ch);
    //连接失败
    if ($result == FALSE) {
        $result = returnFormat(172001, '网络错误');
    }
    curl_close($ch);
    return $result;
}

function array_multiksort(&$rows)
{
    foreach ($rows as $key => $row) {
        if (is_array($row)) {
            array_multiksort($rows[$key]);
        }
    }
    ksort($rows, SORT_STRING);
}

function get_time()
{
    if ('cli' == PHP_SAPI) {
        $time = time();
    } else {
        if (isset($_SERVER['REQUEST_TIME'])) {
            $time = $_SERVER['REQUEST_TIME'];
        } else {
            $time = time();
        }
    }
    return $time;
}

function arrayToXml($arr)
{
    $xml = "<GenerateRequest>";
    foreach ($arr as $key => $val) {
        if (is_array($val)) {
            $xml .= "<" . $key . ">" . arrayToXml($val) . "</" . $key . ">";
        } else {
            $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
        }
    }
    $xml .= "</GenerateRequest>";
    return $xml;
}

function isProcessed($TxnId)
{
    # Check database if order relating to TxnId has alread been processed
    return false;
}


/**
 * 模拟post进行url请求
 * @param string $url
 * @param string $param
 * @return bool|mixed
 */
function request_post($url = '', $param = '') {
    if (empty($url) || empty($param)) {
        return false;
    }

    $postUrl = $url;
    $curlPost = $param;
    $ch = curl_init();//初始化curl
    curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
    curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
    $data = curl_exec($ch);//运行curl
    curl_close($ch);

    return $data;
}