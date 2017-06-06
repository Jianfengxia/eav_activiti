<?php

/**
 * Created by PhpStorm.
 * User: jianfeng.xia
 * Date: 2016/6/24
 * Time: 8:58
 */
class layout extends dbconn
{
    public $baseUrl='/';
    public $currentCUrl;
    public $skinUrl='/';
    public $router;
    public $action;

    public function __construct(){
        $url = $_SERVER['PHP_SELF'];
        $arr= explode( '/' , $url );
        $this->router=$arr[count($arr)-2];
        $this->action=$arr[count($arr)-1];//explode( '.' , $arr[count($arr)-1] )[0];
        $this->currentCUrl=$this->baseUrl.$this->router.'/';
        if (!isset($_SESSION)){
            session_set_cookie_params(3600*24*7);
            session_start();
        }
    }
}