<?php
/**
 * Created by PhpStorm.
 * User: jianfeng.xia
 * Date: 2016/6/13
 * Time: 11:23
 */

require '../layout.php';

$projectList=new EavConnection();
?>

    <div class="row">
        <h1 class="page-header"><?php echo $projectList->getEntityName().'系统' ?></h1>
        <div class="dropdown pull-right">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                新建<span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <?php
                $attributeSetArray=$projectList->getAttributeSetArray();
                foreach($attributeSetArray as $key=>$option){
                    echo '<li><a href="'.$projectList->currentCUrl.'create.php?attribute_set_id='.$key.'&module_id='.$projectList->getModuleId().'">'.$option['attribute_set_name'].'</a></li>';
                }
                ?>
                <!--li role="separator" class="divider"></li-->
            </ul>
        </div>
        <div class="clearfix"></div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <?php
                    $attList=$projectList->getEntityListArray();
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
                    echo '<td><a href="'.$projectList->currentCUrl.'view.php?id='.$key.'">查看</td>';
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>

