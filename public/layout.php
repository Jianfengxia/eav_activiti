<?php
/**
 * Created by PhpStorm.
 * User: jianfeng.xia
 * Date: 2016/6/24
 * Time: 8:55
 */
// 定义 PUBLIC_PATH
define('PUBLIC_PATH', __DIR__);

// 启动器
require PUBLIC_PATH.'/../bootstrap.php';

$layout = new layout();

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
    <link href="<?php echo $layout->skinUrl ?>skin/css/bootstrap.min.css" rel="stylesheet" >
    <link rel="stylesheet" href="<?php echo $layout->skinUrl ?>skin/css/bootstrapValidator.css"/>
    <!-- Custom styles for this template -->
    <link href="<?php echo $layout->skinUrl ?>skin/css/dashboard.css" rel="stylesheet">

    <script src="<?php echo $layout->skinUrl ?>skin/js/jquery.min.js"></script>
    <script src="<?php echo $layout->skinUrl ?>skin/js/bootstrap.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="<?php echo $layout->skinUrl ?>skin/umeditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="<?php echo $layout->skinUrl ?>skin/umeditor/ueditor.all.min.js"></script>
    <script type="text/javascript" src="<?php echo $layout->skinUrl ?>skin/umeditor/lang/zh-cn/zh-cn.js"></script>
    <script type="text/javascript" src="<?php echo $layout->skinUrl ?>skin/js/bootstrapValidator.js"></script>
    <script type="text/javascript" src="<?php echo $layout->skinUrl ?>skin/js/language/zh_CN.js"></script>
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
                $modulesList=new Modules();
                foreach ($modulesList->getModuleArray() as $module){
                    echo '<li><a href="'.$layout->baseUrl.$module['module_name'].'/index.php">'.$module['entity_name'].'</a></li>';
                }
                ?>
                <li><a href="<?php echo $layout->baseUrl.'dev.php'; ?>">属性组编辑工具</a></li>
                <li><a href="<?php echo $layout->baseUrl.'addatt.php'; ?>">属性编辑工具</a></li>
                <?php
                if(isset($_SESSION['user'])){
                    echo '<li><a href="/login.php?logout=1" title="'.$_SESSION['user']['dname'].' : '.$_SESSION['user']['rname'].'">'.$_SESSION['user']['uname'].'(注销)</a><li>';
                } else { ?>
                <li><a href="<?php echo $layout->baseUrl.'login.php'; ?>">登录</a></li>
                <?php } ?>
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

