<?php

/**
 * Created by PhpStorm.
 * User: jianfeng.xia
 * Date: 2016/6/23
 * Time: 15:45
 */
class dbconn
{

    public function conn(){
        $dsn = "mysql:host=localhost;dbname=gtapmo;charset=UTF8";//192.168.106.119
        $db = new PDO($dsn, 'root', 'gta@2015');//, array(ATTR::PDO_EMULATE_PREPARES => true)
        return $db;
    }

}