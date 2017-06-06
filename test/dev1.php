<?php
/**
 * Created by PhpStorm.
 * User: jianfeng.xia
 * Date: 2016/6/20
 * Time: 12:48
 http://blog.csdn.net/ecitnet/article/details/1825075
UPDATE `attribute` SET `is_user_defined`='1', `is_unique`='2', `is_listed`='3' WHERE (`id`='235')
 */

require 'layout.php';

//ini_set('display_errors', 1);error_reporting('E_ALL & ~E_NOTICE ');//错误等级提示

$dbconn = new dbconn();
$db = $dbconn->conn();
$url='dev.php';//http://10.1.44.53/pmo/
?>
    <div class="row">
        <h3>PMO系统有以下模块</h3>
<?php
$modules = $db->query("SELECT id,module_name,entity_name,sort_order FROM modules".' order by sort_order',PDO::FETCH_ASSOC | PDO::FETCH_UNIQUE)->fetchAll();
//var_dump($modules);
?>
        <div class="table-responsive">
            <form method="get" action="dev.php" ><table class="table table-striped">
            <input type="hidden" name="modules_id" value="<?php echo $_GET['modules_id'] ?>" >
            <table class="table table-striped">
<?php
    $selectHtml = '';
    $selectHtmlth = '';
    $selectHtmltd = '';
    foreach($modules[0] as $key=>$row) {
        $selectHtmlth .= '<th>'.$key.'</th>';
        $selectHtmltd .= '<td><input type="text" name="att['.$key.']" placeholder="" class="form-control" value="" ></td>';
    }
    $selectHtml .= '<tr>'.$selectHtmlth.'<th>操作</th></tr>';
    $selectHtml .= '<tr>'.$selectHtmltd.'<td><button type="submit" class="btn btn-success">提交</button></td></tr>';
    foreach($modules as $mid=>$row){
        $selectHtml .= '<tr>';
        foreach($row as $key=>$value){
            if (isset($_GET['modules_id'])){
                $selectHtml .= '<td><input type="text" name="att['.$key.']" placeholder="" class="form-control" value="'.$value.'" ></td>';
            }else{
                $selectHtml .= '<td>'.$value.'</td>';
            }
        }
        $selectHtml .= '<td><a href="dev.php?modules_id='.$mid.'" class="btn btn-primary" >修改</a>
                            <a href="dev.php?modules_id='.$mid.'" class="btn btn-danger" >删除</a></td>
                    </tr>';
    }
    echo $selectHtml;
?>
            </table>
        </div>

<?php
    $selectHtml .= '';

if ($_GET['modules_id']){
    $att_set = $db->query("SELECT id,attribute_set_name,sort_order FROM attribute_set WHERE module_id=".$_GET['modules_id'].' order by sort_order',PDO::FETCH_ASSOC)->fetchAll();
    $attSetHtml = '<h3><b>'.$db->query("select entity_name FROM modules WHERE id=".$_GET['modules_id'].";")->fetch(PDO::FETCH_COLUMN).'</b>模块 有以下类型：</h3>'.getSelect($att_set,'attribute_set','&modules_id='.$_GET['modules_id']);
}
if ($_GET['attribute_set_id']){
    $att_group = $db->query('SELECT  id,attribute_group_name,parent_id,parent_rule,sort_order FROM attribute_group WHERE attribute_set_id='.$_GET['attribute_set_id'].' order by sort_order',PDO::FETCH_ASSOC)->fetchAll();
    $attGroupHtml = '<h3><b>'.$db->query("select attribute_set_name FROM attribute_set WHERE id=".$_GET['attribute_set_id'].";")->fetch(PDO::FETCH_COLUMN).'</b>类型 有以下属性组：</h3>'.getSelect($att_group,'attribute_group','&modules_id='.$_GET['modules_id'].'&attribute_set_id='.$_GET['attribute_set_id']);
    if ($_GET['attribute_group_id']){
        $attArray=$db->query('select * from attribute WHERE module_id='.$_GET['modules_id'].' and id in (SELECT attribute_id FROM entity_attribute WHERE  attribute_group_id='.$_GET['attribute_group_id'].' order by sort_order)')->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_UNIQUE);
        $attSelectArray=$db->query('select * from attribute WHERE module_id='.$_GET['modules_id'].' and id not in (SELECT attribute_id FROM entity_attribute WHERE  attribute_group_id='.$_GET['attribute_group_id'].') order by sort_order')->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_UNIQUE);
        $att_group = $db->query('SELECT id,attribute_id,sort_order FROM entity_attribute WHERE attribute_group_id='.$_GET['attribute_group_id'].' order by sort_order',PDO::FETCH_ASSOC)->fetchAll();
        $entityAttsHtml = '<h3><b>'.$db->query("select attribute_group_name FROM attribute_group WHERE id=".$_GET['attribute_group_id'].";")->fetch(PDO::FETCH_COLUMN).'</b>属性组 有以下属性：</h3>'.getSelect($att_group,'entity_attribute','&modules_id='.$_GET['modules_id'].'&attribute_set_id='.$_GET['attribute_set_id'],$attArray,$attSelectArray,$attParentArray);
    }
}
?>
    </div>
</div>
<?php

?>

<?php
?>