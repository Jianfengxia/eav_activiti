<?php
/**
 * Created by PhpStorm.
 * User: jianfeng.xia
 * Date: 2016/6/24
 * Time: 10:04
 */
require '../layout.php';

$project=new Project($_REQUEST['id']);
//EditAction
$project->attGroupId = $_REQUEST['gid'];

foreach($project->getEavData($project->attGroupId) as $projectValue){
    if (isset($_POST[$projectValue['attribute_code']])&&$_POST[$projectValue['attribute_code']]<>$projectValue['value']){
        $project->setEavData($projectValue['attribute_type'],$projectValue['id'], $_POST[$projectValue['attribute_code']]);
    }
}
//die();
header('Location:'.$project->currentCUrl.'view.php?id='.$project->entityId.'&gid='.$project->attGroupId);