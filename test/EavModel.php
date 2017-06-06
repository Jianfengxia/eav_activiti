<?php

/**
 * Created by PhpStorm.
 * User: jianfeng.xia
 * Date: 2016/6/15
 * Time: 16:55
 */
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);

class EavModel
{
//DB helper
    public $baseUrl='';
    public $router;
    public $action;
    public $entityId;
    public $attGroupId;
    public $attArray;

    private function conn(){
        $dsn = "mysql:host=localhost;dbname=gtapmo;charset=UTF8";//192.168.106.119
        $db = new PDO($dsn, 'root', 'gta@2015');//, array(ATTR::PDO_EMULATE_PREPARES => true)
        return $db;
    }

    public function getModuleArray() {
        return $this->conn()->query("SELECT * FROM modules",PDO::FETCH_ASSOC)->fetchAll();
    }

    public function getCurrentModule() {
        //Get Module
        $currentModule = $this->conn()->query("SELECT * FROM modules WHERE  module_name='".$this->router."'",PDO::FETCH_ASSOC)->fetch();
        return $currentModule;
    }

    public function getCurrentModuleId() {
        //Get Module ID
        return $this->getCurrentModule()['id'];
    }

    public function getEntity() {
        return $this->conn()->query('SELECT * FROM entity WHERE id='.$this->entityId,PDO::FETCH_ASSOC)->fetch();
    }

    public function getAttributeArray($whereArray=array()) {
        $where='';
        foreach($whereArray as $key=>$value) {
            $where.=' and '.$key.'=\''.$value.'\'';
        }
        return $this->conn()->query('select * from attribute WHERE module_id= '.$this->getCurrentModuleId().' '.$where)
            ->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_UNIQUE);
    }

    public function getAttributeGroup() {
        return $this->conn()->query('SELECT * FROM attribute_group
                                          WHERE id='.$this->attGroupId
            , PDO::FETCH_ASSOC)->fetch();
    }

    public function getAttributeGroupArray() {
        return $this->conn()->query('SELECT * FROM attribute_group
                                          WHERE attribute_set_id='.$this->getEntity()['attribute_set_id'].
            ' order by sort_order', PDO::FETCH_ASSOC)->fetchAll();
    }

    public function getEntityAttByGroupBack() {
        return $this->conn()->query('select * from attribute WHERE id in (SELECT attribute_id FROM entity_attribute
                                          WHERE module_id='.$this->getCurrentModuleId().'
                                            and attribute_group_id='.$this->attGroupId.'
                                            order by sort_order);',PDO::FETCH_ASSOC)->fetchAll();
        //and attribute_set_id='.$this->getEntity()['attribute_set_id'].'
    }

    public function getEntityAttByGroup() {
        return $this->conn()->query('SELECT attribute_id FROM entity_attribute
                                          WHERE module_id='.$this->getCurrentModuleId().'
                                            and attribute_set_id='.$this->getEntity()['attribute_set_id'].'
                                            and attribute_group_id='.$this->attGroupId.'
                                            order by sort_order;')->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getAttributeValue($attributeType,$attributeId) {
        return $this->conn()->query("select * from e".$attributeType."
                                            where entity_id=".$this->entityId."
                                            and attribute_id=".$attributeId."
                                            order by updated_at DESC"
            ,PDO::FETCH_ASSOC)->fetch();
    }

    public function getEavData($entityAtts) {
        //Get EAV Data
        $entityArray=array();
        foreach($entityAtts as $attId){
            $att['id']=$attId;
            //$att['attribute_set_id']=$this->attArray[$attId]['attribute_set_id'];
            $att['attribute_type']=$this->attArray[$attId]['attribute_type'];
            $att['attribute_code']=$this->attArray[$attId]['attribute_code'];
            $att['frontend_input']=$this->attArray[$attId]['frontend_input'];
            $att['frontend_label']=$this->attArray[$attId]['frontend_label'];
            $att['is_required']=$this->attArray[$attId]['is_required'];
            $att['option_value']=$this->attArray[$attId]['option_value'];
            $att['note']=$this->attArray[$attId]['note'];
            $attValue=$this->getAttributeValue($att['attribute_type'],$attId);
            if ($attValue) {
                $att['value']=$attValue['value'];
            }else{
                $att['value']='';
            }
            $entityArray[]=$att;
        }
        return $entityArray;
    }

    public function getEntityListArray($limit=10) {
        //Get Entity
        $eavArray=array();
        $entityArray = $this->conn()->query('select * from entity  WHERE module_id= '.$this->getCurrentModuleId().' limit '.$limit,PDO::FETCH_ASSOC)->fetchAll();
        foreach ($entityArray as $entity) {
            $value=array();
            $attArray =  $this->conn()->query('SELECT id,attribute_type,frontend_label FROM attribute WHERE module_id='.$entity['module_id'].' and is_listed=1 order by sort_order;',PDO::FETCH_ASSOC)->fetchAll();
            foreach($attArray as $att){
                $value[$att['frontend_label']] = $this->conn()->query("select value from e".$att['attribute_type']." where entity_id=".$entity['id']." and attribute_id=".$att['id']." order by updated_at DESC;")->fetch(PDO::FETCH_COLUMN);
            }
            $eavArray[$entity['id']]=$value;
        }

        return $eavArray;
    }

    //not in use
    public function setEavData($attribute_type,$id, $attribute_code) {
        echo $sql = 'insert into e'.$attribute_type.' (entity_id,attribute_id,value,updated_at) VALUES ('
            .$this->entityId.','.$id.',\''.$attribute_code.'\',now())';
        $insert = $this->conn()->exec($sql);
        return $insert;
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

    public function editForm(){
        $editForm = '<style>.dl-horizontal dd {margin-bottom: 20px;}.dl-horizontal dt { margin-top: 7px;}input[type=range] {margin-top: 4px;}</style>
                    <form id="attgroup'.$this->attGroupId.'" method="post" action="'.$this->baseUrl.'edit.php" >
                    <input type="hidden" name="id" value="'.$this->entityId.'" >
                    <input type="hidden" name="r" value="'.$this->router.'" >
                    <input type="hidden" name="gid" value="'.$this->attGroupId.'" >
                    <input type="hidden" name="a" value="editAction" >';
        $validator='';
        foreach($this->getEavData($this->getEntityAttByGroup()) as $eavValue){
            if ($eavValue['is_required']){
                $required= ' required ';
                $validator.=$eavValue['attribute_code'].': {validators: {notEmpty: {}}},';
            }

            switch ($eavValue['frontend_input']) {
                case 'tel':
                case 'email':
                case 'search':
                case 'number':
                case 'password':
                case 'color':
                    $eavValue['value']='<div class="form-group"><div class="col-xs-4">
                                        <input type="'.$eavValue['frontend_input'].'" name="'.$eavValue['attribute_code'].'" placeholder=""
                                        '.$required.' class="form-control" value="'.$eavValue['value'].'" ></div>
                                        <span class="help-inline">'.'</span></div>';
                    break;
                case 'range':
                    $eavValue['value']='<div class="form-group"><div class="col-xs-4">
                                        <div class="input-group"><div class="input-group-addon">0</div>
                                        <input type="'.$eavValue['frontend_input'].'" name="'.$eavValue['attribute_code'].'" placeholder=""
                                        '.$required.' value="'.$eavValue['value'].'" min="0" max="100" step="10" >
                                        <div class="input-group-addon">100</div></div></div>
                                        <span class="help-inline">'.'</span></div>';
                    break;
                case 'hidden':
                    $eavValue['frontend_label']='';
                    $eavValue['value']='<input type="'.$eavValue['frontend_input'].'" name="'.$eavValue['attribute_code'].'" placeholder=""
                                    '.$required.' class="form-control" value="'.$eavValue['value'].'" >';
                    break;
                case 'date':
                    $eavValue['value']='<div class="form-group"><div class="col-xs-4">
                                        <input type="'.$eavValue['frontend_input'].'" name="'.$eavValue['attribute_code'].'" placeholder=""
                                        '.$required.' class="form-control" value="'.date('Y-m-d',strtotime($eavValue['value'])).'" ></div>
                                        <span class="help-inline">'.'</span></div>';
                    break;
                case 'price':
                    $eavValue['value']='<div class="form-group"><div class="col-xs-4"> <div class="input-group">
                                        <div class="input-group-addon">￥</div>
                                        <input type="text" name="'.$eavValue['attribute_code'].'" placeholder=""
                                        '.$required.' class="form-control" value="'.$eavValue['value'].'" ></div></div>
                                        <span class="help-inline">'.'</span></div>';
                    break;
                case 'select':
                    $radio='<div class="form-group"><div class="col-xs-4"><select '.$required.'  class="form-control" name="'.$eavValue['attribute_code'].'" >';
                    foreach(explode('|',$eavValue['option_value']) as $key=>$option){
                        $checked='';
                        if ($eavValue['value']===(string)$key ) { $checked=' selected="selected" '; }
                        $radio.='<option value="'.$key.'" '.$checked.' > '.$option.' </option>';
                    }
                    $radio.='</select></div><span class="help-inline">'.'</span></div>';
                    $eavValue['value']=$radio;
                    break;
                case 'radio':
                    $radio='<div class="form-group"><div class="col-xs-6">';
                    foreach(explode('|',$eavValue['option_value']) as $key=>$option){
                        $checked='';
                        if ($eavValue['value']===(string)$key ) { $checked='checked'; }
                        $radio.='<input type="radio" name="'.$eavValue['attribute_code'].'" value="'.$key.'" '.$checked.' > '.$option.' <br>';
                    }
                    $radio.='</div><span class="help-inline">'.'</span></div>';
                    $eavValue['value']=$radio;
                    break;
                case 'file':
                    $eavValue['value']='<div class="form-group"><div class="col-xs-6">
                                        <input type="'.$eavValue['frontend_input'].'" name="'.$eavValue['attribute_code'].'"
                                         '.$required.' class="form-control" value="'.$eavValue['value'].'" ></div>
                                        <span class="help-inline">'.'当前该控件不可用</span></div>';
                    break;
                case 'button':
                    //primary    success    info    warning    danger    link    btn-lg    btn-sm      btn-xs
                    $eavValue['value']='<div class="form-group"><div class="col-xs-2">
                                        <button type="button" class="btn btn-default">（默认样式）'.$eavValue['attribute_code'].'</button>
                                        </div><span class="help-inline">'.'当前该控件不可用</span></div>';
                    break;
                case 'url':
                    $eavValue['value']='<div class="form-group"><div class="col-xs-10"><div class="input-group">
                                        <div class="input-group-addon">URL</div>
                                        <input type="'.$eavValue['frontend_input'].'" name="'.$eavValue['attribute_code'].'" placeholder=""
                                         '.$required.' class="form-control" value="'.$eavValue['value'].'" ></div></div>
                                        <span class="help-inline">'.'</span></div>';
                    break;
                case 'textarea':
                    $eavValue['value']='<div class="form-group"><div class="col-xs-10"><textarea  '.$required.' class="form-control" name="'.$eavValue['attribute_code'].'" rows="5" >'.$eavValue['value'].'</textarea></div><span class="help-inline">'.'</span></div>';
                    break;
                case 'umeditor':
                    /*
                        UE.getEditor('my_tweet',{
                            toolbars:[["link","emotion"]],
                            autoClearinitialContent:true, //编辑器获取焦点时时自动清空初始化时的内容
                            wordCount:true,                 //字数统计
                            maximumWords:140,
                            wordCountMsg : '已输入 {#count} 个字符，您还可以输入{#leave} 个',
                            wordOverFlowMsg : '<span style="color:red;">你输入的字符个数已经超出最大允许值，服务器可能会拒绝保存！</span>',
                            initialFrameHeight:70          //高度
                       });
                    */
                    $eavValue['value']='<div class="form-group"><div class="col-xs-12">
                        <textarea  '.$required.'  name="'.$eavValue['attribute_code'].'" id="'.$eavValue['attribute_code'].'" style="width: 100%;" >'
                        .$eavValue['value'].'</textarea></div><span class="help-inline">'.'</span></div>
                        <script type="text/javascript">var um = UM.getEditor(\''.$eavValue['attribute_code'].'\');</script>';
                    break;
                default:
                    $eavValue['value']='<div class="form-group"><div class="col-xs-6">
                                        <input type="text" name="'.$eavValue['attribute_code'].'" placeholder=""
                                         '.$required.' class="form-control" value="'.$eavValue['value'].'" ></div>
                                        <span class="help-inline">'.'</span></div>';
            }
            $editForm .= '<dt>'.$eavValue['frontend_label'].'</dt><dd>'.$eavValue['value'].'</dd>';
        }
        $editForm .= '<dt><button type="submit" class="btn btn-primary">保存</button></dt><dd></dd></form>';
        $editForm .= "<script type=\"text/javascript\">
                        $(document).ready(function() {
                            $('#attgroup".$this->attGroupId."').bootstrapValidator({fields: {".$validator."}});
                        });
                      </script>";
        return $editForm;
    }

    public function viewForm(){
        $viewForm = '<style>.dl-horizontal dt {margin-bottom: 10px;}</style>';
        foreach($this->getEavData($this->getEntityAttByGroup()) as $eavValue){
            switch ($eavValue['frontend_input']) {
                case 'hidden':
                    $eavValue['frontend_label']='';
                    $eavValue['value']='';
                    break;
                case 'select':
                case 'radio':
                    if ($eavValue['value']){
                        $eavValue['value']=explode('|',$eavValue['option_value'])[$eavValue['value']];
                    }
                    break;
                default:
            }
            $viewForm .= '<dt>'.$eavValue['frontend_label'].'</dt><dd>'.$eavValue['value'].'</dd>';
        }
        return $viewForm;
    }

}


/*

    public function getArray() {
        return $this->conn()->;
    }




    um.addListener(\'blur\',function(){
        $(\'#focush2\').html(\'编辑器失去焦点了\')
    });
            um.addListener(\'focus\',function(){
                $(\'#focush2\').html(\'\')
    });
 */