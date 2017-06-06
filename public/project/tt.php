<?php
/**
 * Created by PhpStorm.
 * User: jianfeng.xia
 * Date: 2016/9/29
 * Time: 10:29
 */

require '../layout.php';

$project=new Project(0);
//EditAction

var_dump($project->getEavData(87));

/*

$project->attGroupId = $_REQUEST['gid'];

foreach($project->getEavData($project->attGroupId) as $projectValue){
    if (isset($_POST[$projectValue['attribute_code']])&&$_POST[$projectValue['attribute_code']]<>$projectValue['value']){
        $project->setEavData($projectValue['attribute_type'],$projectValue['id'], $_POST[$projectValue['attribute_code']]);
    }
}

*/