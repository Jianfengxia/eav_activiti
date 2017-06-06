<?php
/**
 * Created by PhpStorm.
 * User: jianfeng.xia
 * Date: 2016/6/24
 * Time: 10:04
 */
require '../layout.php';

$project=new Project(0);
//CreateAction
//echo $_REQUEST['attribute_set_id'].'---'.$_REQUEST['module_id'];
if (isset($_REQUEST['attribute_set_id'])&&isset($_REQUEST['module_id'])){
    $entityId=$project->createEntity($_REQUEST['attribute_set_id'],$_REQUEST['module_id']);
    if ($entityId){
        header('Location:'.$project->currentCUrl.'view.php?id='.$entityId);
    }else{
        echo '数据库创建实体失败！';
    }
}else{
    echo '缺失参数，创建实体失败！';
}
//die();


