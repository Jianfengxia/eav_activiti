<?php
/**
 * Created by PhpStorm.
 * User: jianfeng.xia
 * Date: 2016/6/13
 * Time: 11:23
 */
require_once __DIR__ . '/EavModel.php';

$eav=new EavModel();

$eav->router = isset($_GET['r']) ? $_GET['r']:'';
$eav->action = isset($_GET['a']) ? $_GET['a']:'';
$eav->entityId = isset($_GET['id']) ? $_GET['id']:'';
$eav->attGroupId = isset($_GET['gid']) ? $_GET['gid']:'';

//var_dump($eav->getEntityAttByGroup());die();
//Get where am I    delete//$moduleName = substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1);
//var_dump($eav->router);die();
if (!$eav->router){
    foreach ($eav->getModuleArray() as $module){
        echo '<li><a href="'.$eav->baseUrl.'index.php?r='.$module['module_name'].'">'.$module['entity_name'].'</a></li>';
    }
    die();
}else{
    $eav->attArray = $eav->getAttributeArray();
}
$url=$eav->baseUrl.'index.php?r='.$eav->router;


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>GTA项目全生命周期协作系统</title>

    <!-- Bootstrap core CSS -->
    <link href="skin/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="skin/css/bootstrapValidator.css"/>
    <!-- Custom styles for this template -->
    <link href="skin/css/dashboard.css" rel="stylesheet">

    <script src="skin/js/jquery.min.js"></script>
    <script src="skin/js/bootstrap.min.js"></script>
    <link href="skin/umeditor/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
    <script type="text/javascript" charset="utf-8" src="skin/umeditor/umeditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="skin/umeditor/umeditor.min.js"></script>
    <script type="text/javascript" src="skin/umeditor/lang/zh-cn/zh-cn.js"></script>
    <script type="text/javascript" src="skin/js/bootstrapValidator.js"></script>
    <script type="text/javascript" src="skin/js/language/zh_CN.js"></script>
</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">GTA项目全生命周期协作系统</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <?php
                foreach ($eav->getModuleArray() as $module){
                    echo '<li><a href="'.$eav->baseUrl.'index.php?r='.$module['module_name'].'">'.$module['entity_name'].'</a></li>';
                }
                ?>
            </ul>
            <!--
            <form class="navbar-form navbar-right">
                <input type="text" class="form-control" placeholder="Search...">
            </form>
            -->
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <?php
        if ($eav->entityId){
            ?>
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <?php
                    //var_dump($eav->attGroupId);var_dump($eav->getAttributeGroupArray());
                    foreach($eav->getAttributeGroupArray() as $attributeGroup){
                        $isActive='';
                        if ($eav->attGroupId==$attributeGroup['id']){ $isActive = ' class="active" ';  }
                        echo '<li '.$isActive.' ><a href="'.$url.'&id='.$eav->entityId.'&gid='.$attributeGroup['id'].'" >'
                            .$attributeGroup['attribute_group_name'].'</a></li>';
                    }
                    ?>
                </ul>
            </div>
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                <?php
                if (!$eav->attGroupId){
                    echo 'no data';
                }else{
                ?>
                <h1 class="page-header"><?php echo $eav->getAttributeGroup()['attribute_group_name']; ?></h1>
                <div class="row">
                    <div class="table-responsive">
                        <dl class="dl-horizontal">
<?php
if ($eav->action=='edit'){
    echo $eav->editForm();
}else{
    echo $eav->viewForm();
    echo '<dt><a href="'.$url.'&id='.$eav->entityId.'&gid='.$eav->attGroupId.'&a=edit" >编辑</a></dt><dd></dd>';
}
?>
                        </dl>
                    </div>
                </div>
                <?php } ?>
            </div>
        <?php } else{ ?>
        <h1 class="page-header">Dashboard</h1>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <?php
                    $attList=$eav->getEntityListArray();
                    if ($attList){
                        foreach(reset($attList) as $att=>$vled){
                            echo '<th>'.$att.'</th>';
                        }
                    }
                    ?>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($attList as $key=>$entity) {
                    echo '<tr>';
                    foreach($entity as $eavValue) {
                        echo '<td>'.$eavValue.'</td>';
                    }
                    echo '<td><a href="'.$url.'&id='.$key.'">查看</td>';
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>
        </div>
        <?php } ?>
    </div>
</div>
</body>
</html>
