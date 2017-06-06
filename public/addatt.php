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

ini_set('display_errors', 1);//设置开启错误提示
error_reporting('E_ALL & ~E_NOTICE ');//错误等级提示

$dbconn = new dbconn();
$db = $dbconn->conn();
$url='addatt.php';//http://10.1.44.53/pmo/

$id=0;
$att=array();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

if (isset($_GET['att'])){
    $result=0;
    if ($id>0){
        $update=array();
        foreach($_GET['att'] as $akey=>$avalue){
            if ($akey<>'id'){
                $update[] = $akey.'=\''.$avalue.'\'';
            }
        }
        $sql='UPDATE attribute SET '.implode(',',$update).' WHERE (`id`=\''.$id.'\');';
        $result = $db->exec($sql);
        //echo $sql.'---'.$result;
        //var_dump($_GET['att']);
        header('Location:'.$url.'?result='.$result);
    }elseif($id==0){
        $sql = 'INSERT INTO attribute ( '.implode(',',array_keys($_GET['att'])).' ) VALUES (\''.implode('\',\'',($_GET['att'])).'\');';
        $result = $db->exec($sql);
        //var_dump($_GET['att']);
        //echo $sql.'---'.$result;
        header('Location:'.$url.'?result='.$result);
    }
}

if (isset($_GET['result'])){
    if ($_GET['result']==1){
        echo '<h3 style="padding: 15px;" class="bg-success">操作成功</h3>';
    }elseif ($_GET['result']==0){
        echo '<h3 style="padding: 15px;" class="bg-danger">操作失败</h3>';
    }
}

$att = $db->query('SELECT id,module_id,attribute_code,attribute_type,frontend_input,frontend_label,is_required,is_user_defined,is_listed,option_value,sort_order FROM attribute ORDER BY sort_order')->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_UNIQUE);

if ($id) {
    echo '<h2>业务属性管理页面 - 修改属性 (<a href="addatt.php" >GoTo新建)</a></h2>';
}else{
    echo '<h2>业务属性管理页面 - 新建属性</h2>';
}

?>
<form action="addatt.php"  method="get" >
    <input type="hidden" name="id" value="<?php echo $id ?>">
    <div class="col-md-2">
        <h4>模块</h4>
        <div class="form-group">
            <select required="" class="form-control" name="att[module_id]" >
                <?php  $modules=$db->query('select * from modules')->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_UNIQUE);
                        foreach($modules as $key=>$value){
                            if ($id&&$key==$att[$id]['module_id']) {
                                $selected=' selected="selected" ';
                            }else {
                                $selected='';
                            }
                            echo '<option '.$selected.' value="'.$key.'">'.$value['entity_name'].'</option>';
                        }?>
            </select>
        </div>
    </div>
    <div class="col-md-1">
        <h4>数据类别</h4>
        <div class="form-group">
            <select required="" class="form-control" name="att[attribute_type]" >
                <?php  $attribute_types=array('varchar','datetime','text','int','decimal');
                foreach($attribute_types as $value){
                    if ($id&&$value==$att[$id]['attribute_type']) {
                        $selected=' selected="selected" ';
                    }else {
                        $selected='';
                    }
                    echo '<option '.$selected.' value="'.$value.'">'.$value.'</option>';
                }?>
            </select>
        </div>
    </div>
    <div class="col-md-1">
        <h4>输入类型</h4>
        <div class="form-group">
            <select required="" class="form-control" name="att[frontend_input]" >
                <?php  $frontend_inputs=array('text'=>'文本框','umeditor'=>'编辑器','array'=>'列表（必填属性选项/数据列组）','date'=>'日期','select'=>'下拉框（必填属性选项/数据列组）','price'=>'价格','tel'=>'电话','email'=>'邮箱','password'=>'密码','number'=>'整数输入框','radio'=>'radio（必填属性选项/数据列组）','textarea'=>'大文本框','hidden'=>'隐藏框','search'=>'搜索框','url'=>'url框','range'=>'百分比框','color'=>'颜色选择器');//'file'=>'file','button'=>'button','datetime'=>'datetime','datetime-local'=>'datetime-local','month'=>'month','week'=>'week','time'=>'time',
                foreach($frontend_inputs as $key=>$value){
                    if ($id&&$key==$att[$id]['frontend_input']) {
                        $selected=' selected="selected" ';
                    }else {
                        $selected='';
                    }
                    echo '<option '.$selected.' value="'.$key.'">'.$key.':'.$value.'</option>';
                }?>
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <h4>属性唯一码</h4>
        <div class="form-group">
            <input type="text" name="att[attribute_code]" value="<?php if($id) echo $att[$id]['attribute_code'] ?>" required="required" class="form-control" >
        </div>
    </div>

    <div class="col-md-2">
        <h4>属性名称</h4>
        <div class="form-group">
            <input type="text" name="att[frontend_label]" value="<?php if($id) echo $att[$id]['frontend_label'] ?>" required="required" class="form-control" >
        </div>
    </div>
    <div class="col-md-1">
        <h4>必填项</h4>
        <div class="form-group">
            <select required="" class="form-control" name="att[is_required]" >
                <?php  $attribute_types=array(0=>'否',1=>'是');
                foreach($attribute_types as $key=>$value){
                    if ($id&&$key==$att[$id]['is_required']) {
                        $selected=' selected="selected" ';
                    }else {
                        $selected='';
                    }
                    echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
                }?>
            </select>
        </div>
    </div>
    <div class="col-md-1">
        <h4>宽度</h4>
        <div class="form-group">
            <select required="" class="form-control" name="att[is_user_defined]" >
                <?php
                for($i=1;$i<13;$i++){
                    if ($id&&$i==$att[$id]['is_user_defined']) {
                        $selected=' selected="selected" ';
                    }else {
                        $selected='';
                    }
                    echo '<option '.$selected.' value="'.$i.'">'.$i.'</option>';
                }?>
            </select>
        </div>
    </div>
    <div class="col-md-1">
        <h4>列表项</h4>
        <div class="form-group">
            <select required="" class="form-control" name="att[is_listed]" >
                <?php  $attribute_types=array(0=>'否',1=>'是');
                foreach($attribute_types as $key=>$value){
                    if ($id&&$key==$att[$id]['is_listed']) {
                        $selected=' selected="selected" ';
                    }else {
                        $selected='';
                    }
                    echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
                }?>
            </select>
        </div>
    </div>
    <div class="col-md-1">
        <h4>列表排序</h4>
        <div class="form-group">
            <input type="number" name="att[sort_order]" value="<?php if($id) echo $att[$id]['sort_order'] ?>" min="0" max="9999" required="required" class="form-control" >
        </div>
    </div>
    <div class="col-md-12">
        <h4>属性选项/数据列组 - 各选项、列之间通过“|”隔开，示例：部门|姓名|项目角色|签到时间</h4>
        <div class="form-group">
            <input type="text" name="att[option_value]" value="<?php if($id) echo $att[$id]['option_value'] ?>" class="form-control" >
        </div>
    </div>
    <div class="col-md-12">
        <button type="submit" class="btn btn-primary">提交</button>
    </div>
</form>
<?php
    $selectHtml = '
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr><th>模块</th><th>代码</th><th>数据类别</th><th>输入类型</th><th>名称</th><th>必填项</th><th>宽度</th><th>列表项</th><th>选项组</th><th>排序</th>
                    </tr>
                </thead>
                <tbody>';
    foreach($att as $id=>$row){
        $selectHtml .= '<tr>';
        foreach($row as $key=>$value){
            if ($key=='module_id') $value=$modules[$value]['entity_name'];
            if ($key=='is_required'||$key=='is_listed') $value=$attribute_types[$value];
            $selectHtml .= '<td>'.$value.'</td>';
        }
        $selectHtml .= '<td><a href="addatt.php?id='.$id.'" class="btn btn-primary">修改</a></td></tr>';
    }
    $selectHtml .= '</tbody>
            </table>
        </div>';
    echo '<div class="col-md-12">'.$selectHtml.'</div>';


?>
</div>
</body>
</html>