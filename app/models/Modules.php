<?php

/**
 * Created by PhpStorm.
 * User: jianfeng.xia
 * Date: 2016/6/23
 * Time: 15:45
 */
class Modules extends layout
{
    public $moduleName;

    public function __construct(){
        parent::__construct();
        $this->moduleName=$this->router;

    }

    public function getModuleArray() {
        return $this->conn()->query("SELECT * FROM modules",PDO::FETCH_ASSOC)->fetchAll();
    }

    public function getModuleByName() {
        //Get Module
        $currentModule = $this->conn()->query("SELECT * FROM modules WHERE  module_name='".$this->moduleName."'",PDO::FETCH_ASSOC)->fetch();
        return $currentModule;
    }

    public function getModuleId() {
        //Get Module ID
        return $this->getModuleByName()['id'];
    }

    public function getEntityName() {
        //Get Module ID
        return $this->getModuleByName()['entity_name'];
    }


}

?>