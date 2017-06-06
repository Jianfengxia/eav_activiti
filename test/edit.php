<script src="skin/umeditor/third-party/jquery.min.js"></script>
<script src="skin/umeditor/third-party/mathquill/mathquill.min.js"></script>
<link rel="stylesheet" href="skin/umeditor/third-party/mathquill/mathquill.css"/>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
<?php
/**
 * Created by PhpStorm.
 * User: jianfeng.xia
 * Date: 2016/6/15
 * Time: 16:32
require_once __DIR__ . '/EavModel.php';

$eav=new EavModel();

//EditAction
if ($_GET['a']=='edit'){
echo $_GET['r'].'&id='.$_GET['id'].'&gid='.$_GET['gid'].'---'.$_GET['a'];
var_dump($_GET['att']);
die();
}
//$getAttValueArray=$_POST['att'];

 */


require_once __DIR__ . '/EavModel.php';

$eav=new EavModel();
//EditAction
$eav->router = $_POST['r'];
$eav->action = $_POST['a'];
$eav->entityId = $_POST['id'];
$eav->attGroupId = $_POST['gid'];

$eav->attArray = $eav->getAttributeArray();
foreach($eav->getEavData($eav->getEntityAttByGroup()) as $eavValue){
    if ($_POST[$eavValue['attribute_code']]<>$eavValue['value']){
        $eav->setEavData($eavValue['attribute_type'],$eavValue['id'], $_POST[$eavValue['attribute_code']]);
    }
}
//die();
header('Location:'.$eav->baseUrl.'index.php?r='.$eav->router.'&id='.$eav->entityId.'&gid='.$eav->attGroupId);