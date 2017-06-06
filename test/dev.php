<?php
/**
 * Created by PhpStorm.
 * User: jianfeng.xia
 * Date: 2016/6/20
 * Time: 12:48
UPDATE `attribute` SET `is_user_defined`='1', `is_unique`='2', `is_listed`='3' WHERE (`id`='235')
 */

$dsn = "mysql:host=localhost;dbname=gtapmo;charset=UTF8";//192.168.106.119
$db = new PDO($dsn, 'root', 'gta@2015');//, array(ATTR::PDO_EMULATE_PREPARES => true)
$url='dev.php';//http://10.1.44.53/pmo/

if($_GET['del']=='1'){//&delid=5230&deltable=entity_attribute
    $sql='Delete from '.$_GET['deltable'].' where id='.$_GET['delid'];
    $result = $db->exec($sql);
    echo $sql.'---'.$result;
    var_dump($_GET['att']);
    $_GET[$_GET['deltable'].'_id']=0;
    //die();
    header('Location:'.$url.'?attribute_group_id='.$_GET['attribute_group_id'].'&modules_id='.$_GET['modules_id'].'&attribute_set_id='.$_GET['attribute_set_id'].'&result='.$result);
}
if ($_GET['table']){
    if ($_GET['att']['id']&&$_GET['att']['id']<>'+'){
        echo $_GET['modules_id'].'-'.$_GET['attribute_set_id'].'-'.$_GET['attribute_group_id'].'<br>';
        $update=array();
        foreach($_GET['att'] as $akey=>$avalue){
            if ($akey<>'id'){
                $update[] = $akey.'=\''.$avalue.'\'';
            }
        }
        $sql='UPDATE '.$_GET['table'].' SET '.implode(',',$update).' WHERE (`id`=\''.$_GET['att']['id'].'\');';
        $result = $db->exec($sql);
        echo $sql.'---'.$result;
        var_dump($_GET['att']);
        //die();
        header('Location:'.$url.'?attribute_group_id='.$_GET['attribute_group_id'].'&modules_id='.$_GET['modules_id'].'&attribute_set_id='.$_GET['attribute_set_id'].'&result='.$result);
    }elseif($_GET['att']['id']=='+'){
        unset($_GET['att']['id']);
        $sql = 'INSERT INTO '.$_GET['table'].' ( '.implode(',',array_keys($_GET['att'])).' ) VALUES (\''.implode('\',\'',($_GET['att'])).'\');';
        $result = $db->exec($sql);
        echo $sql.'---'.$result;
        //die();
        header('Location:'.$url.'?attribute_group_id='.$_GET['attribute_group_id'].'&modules_id='.$_GET['modules_id'].'&attribute_set_id='.$_GET['attribute_set_id'].'&result='.$result);
    }
    else{
        echo 'INSERT INTO '.$_GET['table'].' ( '.implode(',',array_keys($_GET['att'])).' ) VALUES (\''.implode('\',\'',($_GET['att'])).'\');';
        die();
    }
}


function getSelect($db,$table,$gid='',$attArray=array(),$attSelectArray=array()) {
    $hiddenHtml='<input type="hidden" name="modules_id" value="'.$_GET['modules_id'].'" >
            <input type="hidden" name="attribute_set_id" value="'.$_GET['attribute_set_id'].'" >
            <input type="hidden" name="attribute_group_id" value="'.$_GET['attribute_group_id'].'" >';
    $hiddenHtml.= $table=='entity_attribute' ? '<input type="hidden" name="att[module_id]" value="'.$_GET['modules_id'].'" >
                                <input type="hidden" name="att[attribute_set_id]" value="'.$_GET['attribute_set_id'].'" >
                                <input type="hidden" name="att[attribute_group_id]" value="'.$_GET['attribute_group_id'].'" >':'';
    $hiddenHtml.= $table=='attribute_group' ? '<input type="hidden" name="att[attribute_set_id]" value="'.$_GET['attribute_set_id'].'" >':'';
    $hiddenHtml.= $table=='attribute_set' ? '<input type="hidden" name="att[module_id]" value="'.$_GET['modules_id'].'" >':'';
    $selectHtml = '
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr><th><table class="table table-striped"><tr>';
    if (!$db[0]) {
        switch ($table) {
            case 'attribute_set':
                $db[0]['id']='';
                $db[0]['attribute_set_name']='';
                $db[0]['sort_order']='';
                break;
            case 'attribute_group':
                $db[0]['id']='';
                $db[0]['attribute_group_name']='';
                $db[0]['sort_order']='';
                break;
            case 'entity_attribute':
                $db[0]['id']='';
                $db[0]['attribute_id']='';
                $db[0]['sort_order']='';
                break;
            default:
                $db[0]['id']='';
                $db[0]['module_name']='';
                $db[0]['entity_name']='';
                $db[0]['sort_order']='';
        }
    }
    $addSelectHtml='';
    foreach($db[0] as $key=>$row){
        $selectHtml .= '<th>'.$key.'</th>';
        if ($key=='id'){
            $addSelectHtml .= '<td>自增<input type="hidden" name="att['.$key.']" placeholder="" class="form-control" value="+" ></td>';
        }elseif ($key=='attribute_id'){
            $addSelectHtml .= '<td><select class="form-control" name="att['.$key.']" ><option value="" ></option>';
            foreach($attSelectArray as $akey=>$att){
                $addSelectHtml .= '<option value="'.$akey.'" >'.$att['frontend_label'].':'.$att['frontend_input'].'</option>';
            }
            $addSelectHtml .= '</select></td>';
        }else {
            $addSelectHtml .= '<td><input type="text" name="att['.$key.']" placeholder="" class="form-control" value="" ></td>';
        }
    }
    $selectHtml .= '<th>操作</th></tr></th></tr></table>
                </thead>
                <tbody>';
    $selectHtml .= '<tr><th><form method="get" action="dev.php" ><table class="table table-striped"><tr>
                        <input type="hidden" name="table" value="'.$table.'" >'.$hiddenHtml.$addSelectHtml;
    $selectHtml .= '<td><button type="submit" class="btn btn-success">新增</button></td></tr></table></form></tr>';
    foreach($db as $row){
        if ($db[0]['id']){
            $selectHtml .= '<tr><td><form method="get" action="dev.php" ><table class="table table-striped"><tr>
                        <input type="hidden" name="table" value="'.$table.'" >'.$hiddenHtml;
            foreach($row as $key=>$value){
                if ($key=='id'){
                    $selectHtml .= '<td><a href="dev.php?'.$table.'_id='.$value.$gid.'">'.$value.'</a>
                <input type="hidden" name="att['.$key.']" placeholder="" class="form-control" value="'.$value.'" ></td>';
                }elseif ($key=='attribute_id'){
                    $selectHtml .='<td>'.$attArray[$value]['frontend_label'].':'.$attArray[$value]['frontend_input'].'</td>';
                }else {
                    $selectHtml .= '<td><input type="text" name="att['.$key.']" placeholder="" class="form-control" value="'.$value.'" ></td>';
                }
            }
            $selectHtml .= '<td><button type="submit" class="btn btn-primary">修改</button><a href="dev.php?attribute_group_id='.$_GET['attribute_group_id'].$gid.'&del=1&delid='.$row['id'].'&deltable='.$table.'" class="btn btn-danger" >删除</a></td></tr></table></td></form></tr>';
        }
    }
    $selectHtml .= '</tbody>
            </table>
        </div>';
    return $selectHtml;
}
?>
<meta charset="utf-8">
<!-- Bootstrap core CSS -->
<link href="skin/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="skin/css/dashboard.css" rel="stylesheet">

<script src="skin/js/jquery.min.js"></script>
<script src="skin/js/bootstrap.min.js"></script>
<?php
$modules = $db->query("SELECT id,module_name,entity_name,sort_order FROM modules".' order by sort_order',PDO::FETCH_ASSOC)->fetchAll();
//var_dump($modules);
$pmoHtml='<h3>PMO系统有以下模块</h3>'.getSelect($modules,'modules');

if ($_GET['modules_id']){
    $att_set = $db->query("SELECT id,attribute_set_name,sort_order FROM attribute_set WHERE module_id=".$_GET['modules_id'].' order by sort_order',PDO::FETCH_ASSOC)->fetchAll();
    $attSetHtml = '<h3><b>'.$db->query("select entity_name FROM modules WHERE id=".$_GET['modules_id'].";")->fetch(PDO::FETCH_COLUMN).'</b>模块 有以下类型：</h3>'.getSelect($att_set,'attribute_set','&modules_id='.$_GET['modules_id']);
}
if ($_GET['attribute_set_id']){
    $att_group = $db->query("SELECT  id,attribute_group_name,sort_order FROM attribute_group WHERE attribute_set_id=".$_GET['attribute_set_id'].' order by sort_order',PDO::FETCH_ASSOC)->fetchAll();
    $attGroupHtml = '<h3><b>'.$db->query("select attribute_set_name FROM attribute_set WHERE id=".$_GET['attribute_set_id'].";")->fetch(PDO::FETCH_COLUMN).'</b>类型 有以下属性组：</h3>'.getSelect($att_group,'attribute_group','&modules_id='.$_GET['modules_id'].'&attribute_set_id='.$_GET['attribute_set_id']);
    if ($_GET['attribute_group_id']){
        $attArray=$db->query('select * from attribute WHERE module_id='.$_GET['modules_id'].' and id in (SELECT attribute_id FROM entity_attribute WHERE attribute_set_id='.$_GET['attribute_set_id'].' and module_id='.$_GET['modules_id'].' and attribute_group_id='.$_GET['attribute_group_id'].' order by sort_order)')->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_UNIQUE);
        $attSelectArray=$db->query('select * from attribute WHERE module_id='.$_GET['modules_id'].' and id not in (SELECT attribute_id FROM entity_attribute WHERE attribute_set_id='.$_GET['attribute_set_id'].' and module_id='.$_GET['modules_id'].' and attribute_group_id='.$_GET['attribute_group_id'].') order by sort_order')->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_UNIQUE);
        $att_group = $db->query('SELECT id,attribute_id,sort_order FROM entity_attribute WHERE attribute_set_id='.$_GET['attribute_set_id'].' and module_id='.$_GET['modules_id'].' and attribute_group_id='.$_GET['attribute_group_id'].' order by sort_order',PDO::FETCH_ASSOC)->fetchAll();
        $entityAttsHtml = '<h3><b>'.$db->query("select attribute_group_name FROM attribute_group WHERE id=".$_GET['attribute_group_id'].";")->fetch(PDO::FETCH_COLUMN).'</b>属性组 有以下属性：</h3>'.getSelect($att_group,'entity_attribute','&modules_id='.$_GET['modules_id'].'&attribute_set_id='.$_GET['attribute_set_id'],$attArray,$attSelectArray);
    }
}
if ($_GET['result']==1){
    echo '<p class="bg-success">操作成功</p>';
}elseif ($_GET['result']==='0'){
    echo '<p class="bg-danger">操作失败</p>';
}

echo '<style>.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {width: 30%;}</style>';

echo $entityAttsHtml.$attGroupHtml.$attSetHtml.$pmoHtml;

