<?php

/**
 * Created by PhpStorm.
 * User: jianfeng.xia
 * Date: 2016/6/15
 * Time: 16:55
 */
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);

class Eav_entity_attribute_chaifen extends layout
{
    public $moduleId;
    public $moduleName;
    public $entityId;
    public $attributeSetId;
    public $attGroupId;
    public $attArray;


    public function __construct($entityId){
        parent::__construct();
        $this->moduleName=$this->router;
        $this->entityId = $entityId;
        $entity=$this->getEntity();
        $this->moduleId = $entity['module_id'];
        $this->attributeSetId = $entity['attribute_set_id'];
        $this->attArray = $this->getAttributeArray();
        $this->attGroupId =key($this->getAttributeGroupArray());
    }

    public function getEntity() {
        $entityTableName=$this->moduleName.'_entity';
        $has_table=$this->conn()->query('SHOW TABLE STATUS LIKE \''.$entityTableName.'\';')->fetch(PDO::FETCH_COLUMN);
        //var_dump($has_table);
        if (!$has_table){
            $this->createModule($this->moduleName);
        }
        $entity=$this->conn()->query('SELECT * FROM '.$this->moduleName.'_entity WHERE id='.$this->entityId,PDO::FETCH_ASSOC)->fetch();
        if (!$entity){
            //echo '无数据';die();跳转到新建页面

        }
        return $entity;
    }

    public function getAttributeArray($whereArray=array()) {
        /*$where='';
        foreach($whereArray as $key=>$value) {
            $where.=' and '.$key.'=\''.$value.'\'';
        }
        return $this->conn()->query('select * from attribute WHERE module_id= '.$this->moduleId.' '.$where)
            ->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_UNIQUE);
        */
        return $this->conn()->query('select * from attribute;')->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_UNIQUE);
    }

    public function getAttributeGroupArray() {
        $where='';
        if (isset($this->attributeSetId)){
            $where = 'WHERE attribute_set_id='.$this->attributeSetId;
        }
        return $this->conn()->query('SELECT * FROM attribute_group '.$where.' order by sort_order')->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_UNIQUE);
    }

    public function getAttributeValue($attributeType,$attributeId) {
        return $this->conn()->query('select `value` from '.$this->moduleName.'_e'.$attributeType.'
                                            where entity_id='.$this->entityId.'
                                            and attribute_id='.$attributeId.'
                                            order by updated_at DESC LIMIT 1'
                                            )->fetch(PDO::FETCH_COLUMN);
    }

    public function getEavData($attGroupId) {
        $entityArray=array();
        $sql='SELECT attribute_id FROM entity_attribute WHERE module_id='.$this->moduleId.' and attribute_set_id='.$this->attributeSetId.' and attribute_group_id='.$attGroupId.' order by sort_order;';

        $entityAtts=$this->conn()->query($sql)->fetchAll(PDO::FETCH_COLUMN);
        foreach($entityAtts as $attId){
            $att['id']=$attId;
            if (!in_array($attId,array_keys($this->attArray))) {
                continue;
            }
            //$att['attribute_set_id']=$this->attArray[$attId]['attribute_set_id'];
            $att['attribute_type']=$this->attArray[$attId]['attribute_type'];
            $att['attribute_code']=$this->attArray[$attId]['attribute_code'];
            $att['frontend_input']=$this->attArray[$attId]['frontend_input'];
            $att['frontend_label']=$this->attArray[$attId]['frontend_label'];
            $att['is_user_defined']=$this->attArray[$attId]['is_user_defined'];
            $att['is_required']=$this->attArray[$attId]['is_required'];
            $att['option_value']=$this->attArray[$attId]['option_value'];
            $att['note']=$this->attArray[$attId]['note'];
            $attValue=$this->getAttributeValue($att['attribute_type'],$attId);
            if ($attValue) {
                $att['value']=$attValue;
            }else{
                $att['value']='';
            }
            $entityArray[]=$att;
        }
        return $entityArray;
    }

    //
    public function setEavData($attribute_type,$id, $value,$is_insert=0) {
        if (is_array($value)){
            $value=serialize($value);
        }
        if ($this->attArray[$id]['frontend_input']=='umeditor'){
            $value=htmlspecialchars($value);
        }
        if($this->conn()->query('SELECT count(*) FROM '.$this->moduleName.'_e'.$attribute_type.' where entity_id='.$this->entityId.' and attribute_id='.$id)->fetch(PDO::FETCH_COLUMN)==0){
            $is_insert=1;
        }
        if ($is_insert==1){
            $sql = 'insert into '.$this->moduleName.'_e'.$attribute_type.' (entity_id,attribute_id,value,updated_at) VALUES ('.$this->entityId.','.$id.',\''.$value.'\',now())';
        }else{
            $sql = 'update '.$this->moduleName.'_e'.$attribute_type.' set value=\''.$value.'\' where entity_id='.$this->entityId.' and attribute_id='.$id;
        }
        $execSql = $this->conn()->exec($sql);
        return $execSql;
        /*
         * foreach($this->getEavData($this->getEntityAttByGroup()) as $eavValue){
            if ($getAttValueArray[$eavValue['attribute_code']]<>$eavValue['value']){
                echo $sql = 'insert into e'.$eavValue['attribute_type'].' (entity_id,attribute_id,value,updated_at) VALUES ('
                    .$this->entityId.','.$eavValue['id'].',\''.$getAttValueArray[$eavValue['attribute_code']].'\',now())';
                $insert = $this->conn()->exec($sql);
            }
        }
         */
    }

    //
    public function createModule($moduleName,$isDrop=0) {
        $execSql='module name cannot be null!';
        if ($moduleName){
            $sql = '';
            if ($isDrop==999){
                $sql .= '
                    DROP TABLE IF EXISTS `'.$moduleName.'_entity`;
                    DROP TABLE IF EXISTS `'.$moduleName.'_edatetime`;
                    DROP TABLE IF EXISTS `'.$moduleName.'_edecimal`;
                    DROP TABLE IF EXISTS `'.$moduleName.'_eint`;
                    DROP TABLE IF EXISTS `'.$moduleName.'_etext`;
                    DROP TABLE IF EXISTS `'.$moduleName.'_evarchar`;';
            }
            $sql .= '
                CREATE TABLE `'.$moduleName.'_entity` (
                  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                  `module_id` smallint(5),
                  `attribute_set_id` smallint(5) DEFAULT NULL,
                  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                CREATE TABLE `'.$moduleName.'_edatetime` (
                  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                  `entity_id` int(11),
                  `attribute_id` smallint(5),
                  `value` datetime,
                  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                CREATE TABLE `'.$moduleName.'_edate` (
                  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                  `entity_id` int(11),
                  `attribute_id` smallint(5),
                  `value` date,
                  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                CREATE TABLE `'.$moduleName.'_edecimal` (
                  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                  `entity_id` int(11),
                  `attribute_id` smallint(5),
                  `value` decimal(12,2),
                  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                CREATE TABLE `'.$moduleName.'_eint` (
                  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                  `entity_id` int(11),
                  `attribute_id` smallint(5),
                  `value` int(11),
                  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                CREATE TABLE `'.$moduleName.'_etext` (
                  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                  `entity_id` int(11),
                  `attribute_id` smallint(5),
                  `value` text,
                  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                CREATE TABLE `'.$moduleName.'_evarchar` (
                  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                  `entity_id` int(11),
                  `attribute_id` smallint(5),
                  `value` varchar(255),
                  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                INSERT INTO `'.$moduleName.'_entity` (module_id,attribute_set_id) VALUES ('.$this->moduleId.',14);
                INSERT INTO entity_attribute (`module_id`, `attribute_set_id`, `attribute_group_id`, `attribute_id`) SELECT  '.$this->moduleId.',14,21,id FROM attribute WHERE `attribute_code` LIKE \'exp_%\';';
            $execSql = $this->conn()->exec($sql);
        }

        return $execSql;
    }

    //
    public function createEntity($attributeSetId,$modulesId) {
        $entityId=0;
        if ($attributeSetId&&$modulesId){
            $sql = 'INSERT INTO `'.$this->moduleName.'_entity` (module_id,attribute_set_id) VALUES ('.$modulesId.','.$attributeSetId.');';
            $execSql = $this->conn();
            $execSql->exec($sql);
            $entityId=$execSql->lastInsertId();
        }
        return $entityId;
    }

}

