<?php

/**
 * Created by PhpStorm.
 * User: jianfeng.xia
 * Date: 2016/6/24
 * Time: 9:26
 */
class EavConnection extends Modules
{

    public function getAttributeSetArray() {
        return $this->conn()->query('SELECT id,attribute_set_name FROM attribute_set WHERE module_id='.$this->getModuleId().' order by sort_order')->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_UNIQUE);
    }

    public function getEntityListArray($limitfrom=0,$limit=10) {
        //Get Entity
        //echo 'select * from entity  WHERE module_id= '.$this->getModuleId().$this->router;die();
        $eavArray=array();
        $entityArray = $this->conn()->query('select * from '.$this->moduleName.'_entity  WHERE module_id= '.$this->getModuleId().' limit '.$limitfrom.','.$limit,PDO::FETCH_ASSOC)->fetchAll();
        foreach ($entityArray as $entity) {
            $value=array();
            $attArray =  $this->conn()->query('SELECT id,attribute_type,frontend_label FROM attribute WHERE module_id='.$entity['module_id'].' and is_listed=1 order by sort_order;',PDO::FETCH_ASSOC)->fetchAll();
            foreach($attArray as $att){
                $value[$att['frontend_label']] = $this->conn()->query("select value from ".$this->moduleName."_e".$att['attribute_type']." where entity_id=".$entity['id']." and attribute_id=".$att['id']." order by updated_at DESC;")->fetch(PDO::FETCH_COLUMN);
            }
            $eavArray[$entity['id']]=$value;
        }

        return $eavArray;
    }

}