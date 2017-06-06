<?php
/**
 * Created by PhpStorm.
 * User: jianfeng.xia
 * Date: 2016/6/24
 * Time: 10:04
 */
require '../layout.php';

$project=new Project($_GET['id']);
?>
<div class="row">
    <?php
    if ($project->entityId){ ?>
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <?php
                if (isset($_GET['gid'])){
                    $project->attGroupId=$_GET['gid'];
                }
                //var_dump($project->attGroupId);var_dump($project->getAttributeGroupArray());
                foreach($project->getAttributeGroupArray() as $attGroupId=>$attributeGroup){
                    $isActive='';
                    if ($project->attGroupId==$attGroupId){ $isActive = ' class="active" ';  }
                    echo '<li '.$isActive.' ><a href="'.$project->currentCUrl.'view.php?id='.$project->entityId.'&gid='.$attGroupId.'" >'.$attributeGroup['attribute_group_name'].'</a></li>';
                }
                ?>
                <li><img class="workflow-info" src="/skin/image/workflow.png" /></li>
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <?php
            if (!$project->attGroupId){
                echo 'no data';
            }else{
                ?>
                <h1 class="page-header" id="<?php //echo "attGroupId'.$project->attGroupId.'" ?>"><?php echo $project->getAttributeGroupArray()[$project->attGroupId]['attribute_group_name']; ?></h1>
                <div class="row">
                    <?php
                    if (isset($_GET['edit'])){
                        echo $project->editForm($project->attGroupId);
                    }else{
                        echo $project->viewForm($project->attGroupId);
                    }
                    ?>
                </div>
            <?php } ?>
        </div>
    <?php } else{
        header('Location:'.$project->baseUrl.'404.php');
    } ?>
</div>
</div>
</body>
</html>
