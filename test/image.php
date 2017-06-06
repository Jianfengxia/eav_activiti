<?php
/**
 * Created by PhpStorm.
 * User: jianfeng.xia
 * Date: 2016/7/27
 * Time: 16:47
 */

define('PUBLIC_PATH', __DIR__);

// 启动器
require PUBLIC_PATH.'/../bootstrap.php';

$layout = new layout();

function restApi($method,$url){
    $response = \Httpful\Request::$method($url)->authenticateWith('kermit', 'kermit');
    return $response;
}

$baseUrl = "http://10.1.134.129:8080/activiti-rest/service/";

$response = restApi('get',$baseUrl.'repository/deployments')->send();
var_dump($response->body);
$response = restApi('get',$baseUrl.'repository/deployments/8573/resourcedata/pmlc2.pm1.png')->send();

echo '<img src="data:image/gif;base64,'.base64_encode($response).'" >';
$response = restApi('get',$baseUrl.'repository/deployments')->send();