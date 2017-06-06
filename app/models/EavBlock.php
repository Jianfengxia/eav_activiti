<?php
/**
 * Created by PhpStorm.
 * User: jianfeng.xia
 * Date: 2016/6/23
 * Time: 15:55
 */
class EavBlock extends Eav
{
    public function editForm($attGroupId){
        $editForm = '<form id="attgroup'.$attGroupId.'" method="post" action="'.$this->currentCUrl.'edit.php" >
                    <input type="hidden" name="id" value="'.$this->entityId.'" >
                    <input type="hidden" name="r" value="'.$this->router.'" >
                    <input type="hidden" name="gid" value="'.$attGroupId.'" >
                    <input type="hidden" name="a" value="editAction" >';
        foreach($this->getEavData($attGroupId) as $eavValue){
            $eavValue=$this->formUnit($eavValue);
            $colX=isset($eavValue['is_user_defined']) ? $eavValue['is_user_defined'] : 6;
            $editForm .= '<div class="col-md-'.$colX.' widget"><h4 class="elabel">'.$eavValue['frontend_label'].'</h4>
            <div class="form-group">'.$eavValue['value'].'</div></div>';
        }
        $editForm .= '<div class="col-md-12 widget"><button type="submit" class="btn btn-primary">提交申请</button></div></form>';
        $editForm .= "<script type=\"text/javascript\">
                        $(document).ready(function() {
                            $('#attgroup".$attGroupId."').bootstrapValidator({fields: {".$eavValue['validator']."}});
                        });
                      </script>";
        return $editForm;
    }

    public function viewForm($attGroupId){
        $viewForm = '';
        foreach($this->getEavData($attGroupId) as $eavValue){
            switch ($eavValue['frontend_input']) {
                case 'hidden':
                    $eavValue['frontend_label']='';
                    $eavValue['value']='';
                    break;
                case 'select':
                case 'radio':
                    if ($eavValue['value']){
                        $eavValue['value']=explode('|',$eavValue['option_value'])[$eavValue['value']];
                    }
                    break;
                case 'color':
                    if ($eavValue['value']){
                        $eavValue['value']='<span style="background-color: '.$eavValue['value'].'" >&nbsp;&nbsp;&nbsp;&nbsp;</span>';
                    }
                    break;
                case 'umeditor':
                    $eavValue['value']=htmlspecialchars_decode($eavValue['value']);
                    break;
                case 'gantt':
                    $eavValue['value']='<iframe style="width: 100%;height: 600px;" src="http://10.1.134.114:55555/skin/gantt/gantt.html"></iframe>';
                    break;
                case 'array':
                    if ($eavValue['value']){
                        $arrayCol=explode('|',$eavValue['option_value']);
                        $tableHtml='<div class="table-responsive"><table class="table table-striped"><thead><tr><th>'.str_replace('|','</th><th>',$eavValue['option_value']).'</th></tr></thead><tbody>';
                        foreach(unserialize($eavValue['value']) as $tr){
                            $tableHtml.='<tr>';
                            foreach($arrayCol as $key){
                                if (!array_key_exists($key,$tr)){$tr[$key]='';}
                                $tableHtml.='<td>'.$tr[$key].'</td>';
                            }
                            $tableHtml.='</tr>';
                        }
                        $tableHtml.='</tbody></table></div>';
                        $eavValue['value']=$tableHtml;
                    }
                    break;
                default:
            }
            $colX=isset($eavValue['is_user_defined']) ? $eavValue['is_user_defined'] : 6;
            $viewForm .= '<div class="col-md-'.$colX.' widget"><h5 class="wlabel" ><b>'.$eavValue['frontend_label'].'</b></h5><h5 class="wvalue" >'.$eavValue['value'].'</h5></div>';
        }
        $viewForm.='<div class="col-md-12 widget"><a href="'.$this->currentCUrl.'view.php?id='.$this->entityId.'&gid='.$this->attGroupId.'&edit=1" class="btn btn-success" >变更申请</a></div>';
        return $viewForm;
    }

    public function formUnit($eavValue){
        $eavValue['validator']='';
        $required='';
        if ($eavValue['is_required']==1){
            $required= ' required ';
            $eavValue['validator'].=$eavValue['attribute_code'].': {validators: {notEmpty: {}}},';
        }
        switch ($eavValue['frontend_input']) {
            case 'tel':
            case 'email':
            case 'search':
            case 'number':
            case 'password':
            case 'color':
                $eavValue['value']='<input type="'.$eavValue['frontend_input'].'" name="'.$eavValue['attribute_code'].'" placeholder=""
                                        '.$required.' class="form-control" value="'.$eavValue['value'].'" >';
                break;
            case 'range':
                $eavValue['value']='<div style="margin-top: 16px;" class="input-group"><div class="input-group-addon">0</div>
                                        <input style="margin-top: 6px;" type="'.$eavValue['frontend_input'].'" name="'.$eavValue['attribute_code'].'" placeholder=""
                                        '.$required.' value="'.$eavValue['value'].'" min="0" max="100" step="10" >
                                        <div class="input-group-addon">100</div></div>';
                break;
            case 'hidden':
                $eavValue['frontend_label']='';
                $eavValue['value']='<input type="'.$eavValue['frontend_input'].'" name="'.$eavValue['attribute_code'].'" placeholder=""
                                     class="form-control" value="'.$eavValue['value'].'" >';
                break;
            case 'date':
                $eavValue['value']='<input type="'.$eavValue['frontend_input'].'" name="'.$eavValue['attribute_code'].'" placeholder=""
                                        '.$required.' class="form-control" value="'.date('Y-m-d',strtotime($eavValue['value'])).'" > ';
                break;
            case 'price':
                $eavValue['value']='<div class="input-group"><div class="input-group-addon">￥</div>
                                        <input type="text" name="'.$eavValue['attribute_code'].'" placeholder=""
                                        '.$required.' class="form-control" value="'.$eavValue['value'].'" ></div> ';
                break;
            case 'select':
                $radio='<select '.$required.'  class="form-control" name="'.$eavValue['attribute_code'].'" >';
                foreach(explode('|',$eavValue['option_value']) as $key=>$option){
                    $checked='';
                    if ($eavValue['value']===(string)$key ) { $checked=' selected="selected" '; }
                    $radio.='<option value="'.$key.'" '.$checked.' > '.$option.' </option>';
                }
                $radio.='</select> ';
                $eavValue['value']=$radio;
                break;
            case 'radio':
                $radio='<div style="margin:16px 0px 21px 0px;">';
                foreach(explode('|',$eavValue['option_value']) as $key=>$option){
                    $checked='';
                    if ($eavValue['value']===(string)$key ) { $checked='checked'; }
                    if($option){
                        $radio.='<input type="radio" name="'.$eavValue['attribute_code'].'" value="'.$key.'" '.$checked.' > '.$option.', ';
                    }
                }
                $eavValue['value']=$radio.'</div>';
                break;
            case 'file':
                $eavValue['value']='<input type="'.$eavValue['frontend_input'].'" name="'.$eavValue['attribute_code'].'"'.$required.' class="form-control" value="'.$eavValue['value'].'" > ';
                break;
            case 'button':
                //primary    success    info    warning    danger    link    btn-lg    btn-sm      btn-xs
                $eavValue['value']='<button type="button" class="btn btn-default">'.$eavValue['value'].'</button>';
                break;
            case 'url':
                $eavValue['value']='<div class="input-group"><div class="input-group-addon">URL</div>
                                        <input type="'.$eavValue['frontend_input'].'" name="'.$eavValue['attribute_code'].'" placeholder="" '.$required.' class="form-control" value="'.$eavValue['value'].'" ></div> ';
                break;
            case 'textarea':
                $eavValue['value']='<textarea '.$required.' class="form-control" name="'.$eavValue['attribute_code'].'" rows="5" >'.$eavValue['value'].'</textarea> ';
                break;
            case 'umeditor':
                $eavValue['value']='<textarea '.$required.' name="'.$eavValue['attribute_code'].'" id="'.$eavValue['attribute_code'].'" style="width: 100%;" >'.$eavValue['value'].'</textarea> <script type="text/javascript">var ue = UE.getEditor(\''.$eavValue['attribute_code'].'\');</script>';
                break;
            case 'list':
                $eavValue['value']='控件开发中……';
                break;
            case 'gantt':
                $eavValue['value']='<iframe style="width: 100%;height: 100%;" src="http://10.1.134.114:55555/skin/gantt/gantt.html"></iframe>';
                break;
            case 'array':
                $arrayCol=explode('|',$eavValue['option_value']);
                $tableHtml='
                    <div class="table-responsive">
                    <table class="table table-striped">
                        <thead><tr><th>'.str_replace('|','</th><th>',$eavValue['option_value']).'</th><th></th></tr></thead><tbody>';
                $i=1;
                if ($eavValue['value']){
                    foreach(unserialize($eavValue['value']) as $tr){
                        $tableHtml.='<tr>';
                        foreach($arrayCol as $key){
                            if (!array_key_exists($key,$tr)){$tr[$key]='';}
                            $tableHtml.='<td><input type="text" name="'.$eavValue['attribute_code'].'['.$i.']['.$key.']" class="form-control" value="'.$tr[$key].'" ></td>';
                        }
                        $tableHtml.='<td><button type="button" class="trash btn btn-danger" >删除</button></td></tr>';
                        $i++;
                    }
                }
                $addRowHtml='';
                $tableRowHtml='<tr>';
                foreach($arrayCol as $td){
                    $addRowHtml.='<td></td>';
                    $tableRowHtml.='<td><input type="text" name="'.$eavValue['attribute_code'].'[\'+$("#addrowid'.$eavValue['id'].'").attr("value")+\']['.$td.']" class="form-control" value="" ></td>';
                }
                $tableRowHtml.='<td><button type="button" class="trash btn btn-danger" >删除</button></td></tr>';
                $tableHtml.='<tr>'.$addRowHtml.'<td><button type="button" class="addrow'.$eavValue['id'].' btn btn-success" >新增</button></td></tr></tbody></table></div>
                        <input type="hidden" id="addrowid'.$eavValue['id'].'" value="'.$i.'" >
                        <script type="text/javascript">
                            $(document).on(\'click\', \'.trash\', function() {$(this).closest(\'tr\').remove();});
                            $(\'.addrow'.$eavValue['id'].'\').on(\'click\', function() {
                                var tableBody = $(this).closest(\'tbody\'),trNew = \''.$tableRowHtml.'\';
                                tableBody.find(\'tr:last\').before(trNew);
                                $("#addrowid'.$eavValue['id'].'").attr("value",(Number($("#addrowid'.$eavValue['id'].'").attr("value"))+1));
                            });
                        </script>';
                $eavValue['value']=$tableHtml;
                break;
            default:
                $eavValue['value']='<input type="text" name="'.$eavValue['attribute_code'].'" placeholder="" '.$required.' class="form-control" value="'.$eavValue['value'].'" > ';
        }
        return $eavValue;
    }

}