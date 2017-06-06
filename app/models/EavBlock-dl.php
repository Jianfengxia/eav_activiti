<?php

/**
 * Created by PhpStorm.
 * User: jianfeng.xia
 * Date: 2016/6/23
 * Time: 15:55
 */
class EavBlock_dl extends Eav
{
    public function editForm($attGroupId){
        $editForm = '
                    <div class="table-responsive">
                        <dl class="dl-horizontal"><style>.dl-horizontal dd {margin-bottom: 20px;}.dl-horizontal dt { margin-top: 7px;}input[type=range] {margin-top: 4px;}</style>
                    <form id="attgroup'.$attGroupId.'" method="post" action="'.$this->currentCUrl.'edit.php" >
                    <input type="hidden" name="id" value="'.$this->entityId.'" >
                    <input type="hidden" name="r" value="'.$this->router.'" >
                    <input type="hidden" name="gid" value="'.$attGroupId.'" >
                    <input type="hidden" name="a" value="editAction" >';
        $validator='';
        foreach($this->getEavData($attGroupId) as $eavValue){
            if ($eavValue['is_required']){
                $required= ' required ';
                $validator.=$eavValue['attribute_code'].': {validators: {notEmpty: {}}},';
            }

            switch ($eavValue['frontend_input']) {
                case 'tel':
                case 'email':
                case 'search':
                case 'number':
                case 'password':
                case 'color':
                    $eavValue['value']='<div class="form-group"><div class="col-xs-4">
                                        <input type="'.$eavValue['frontend_input'].'" name="'.$eavValue['attribute_code'].'" placeholder=""
                                        '.$required.' class="form-control" value="'.$eavValue['value'].'" ></div>
                                        <span class="help-inline">'.'</span></div>';
                    break;
                case 'range':
                    $eavValue['value']='<div class="form-group"><div class="col-xs-4">
                                        <div class="input-group"><div class="input-group-addon">0</div>
                                        <input type="'.$eavValue['frontend_input'].'" name="'.$eavValue['attribute_code'].'" placeholder=""
                                        '.$required.' value="'.$eavValue['value'].'" min="0" max="100" step="10" >
                                        <div class="input-group-addon">100</div></div></div>
                                        <span class="help-inline">'.'</span></div>';
                    break;
                case 'hidden':
                    $eavValue['frontend_label']='';
                    $eavValue['value']='<input type="'.$eavValue['frontend_input'].'" name="'.$eavValue['attribute_code'].'" placeholder=""
                                    '.$required.' class="form-control" value="'.$eavValue['value'].'" >';
                    break;
                case 'date':
                    $eavValue['value']='<div class="form-group"><div class="col-xs-4">
                                        <input type="'.$eavValue['frontend_input'].'" name="'.$eavValue['attribute_code'].'" placeholder=""
                                        '.$required.' class="form-control" value="'.date('Y-m-d',strtotime($eavValue['value'])).'" ></div>
                                        <span class="help-inline">'.'</span></div>';
                    break;
                case 'price':
                    $eavValue['value']='<div class="form-group"><div class="col-xs-4"> <div class="input-group">
                                        <div class="input-group-addon">￥</div>
                                        <input type="text" name="'.$eavValue['attribute_code'].'" placeholder=""
                                        '.$required.' class="form-control" value="'.$eavValue['value'].'" ></div></div>
                                        <span class="help-inline">'.'</span></div>';
                    break;
                case 'select':
                    $radio='<div class="form-group"><div class="col-xs-4"><select '.$required.'  class="form-control" name="'.$eavValue['attribute_code'].'" >';
                    foreach(explode('|',$eavValue['option_value']) as $key=>$option){
                        $checked='';
                        if ($eavValue['value']===(string)$key ) { $checked=' selected="selected" '; }
                        $radio.='<option value="'.$key.'" '.$checked.' > '.$option.' </option>';
                    }
                    $radio.='</select></div><span class="help-inline">'.'</span></div>';
                    $eavValue['value']=$radio;
                    break;
                case 'radio':
                    $radio='<div class="form-group"><div class="col-xs-6">';
                    foreach(explode('|',$eavValue['option_value']) as $key=>$option){
                        $checked='';
                        if ($eavValue['value']===(string)$key ) { $checked='checked'; }
                        $radio.='<input type="radio" name="'.$eavValue['attribute_code'].'" value="'.$key.'" '.$checked.' > '.$option.' <br>';
                    }
                    $radio.='</div><span class="help-inline">'.'</span></div>';
                    $eavValue['value']=$radio;
                    break;
                case 'file':
                    $eavValue['value']='<div class="form-group"><div class="col-xs-6">
                                        <input type="'.$eavValue['frontend_input'].'" name="'.$eavValue['attribute_code'].'"
                                         '.$required.' class="form-control" value="'.$eavValue['value'].'" ></div>
                                        <span class="help-inline">'.'当前该控件不可用</span></div>';
                    break;
                case 'button':
                    //primary    success    info    warning    danger    link    btn-lg    btn-sm      btn-xs
                    $eavValue['value']='<div class="form-group"><div class="col-xs-2">
                                        <button type="button" class="btn btn-default">（默认样式）'.$eavValue['attribute_code'].'</button>
                                        </div><span class="help-inline">'.'当前该控件不可用</span></div>';
                    break;
                case 'url':
                    $eavValue['value']='<div class="form-group"><div class="col-xs-10"><div class="input-group">
                                        <div class="input-group-addon">URL</div>
                                        <input type="'.$eavValue['frontend_input'].'" name="'.$eavValue['attribute_code'].'" placeholder=""
                                         '.$required.' class="form-control" value="'.$eavValue['value'].'" ></div></div>
                                        <span class="help-inline">'.'</span></div>';
                    break;
                case 'textarea':
                    $eavValue['value']='<div class="form-group"><div class="col-xs-10"><textarea  '.$required.' class="form-control" name="'.$eavValue['attribute_code'].'" rows="5" >'.$eavValue['value'].'</textarea></div><span class="help-inline">'.'</span></div>';
                    break;
                case 'umeditor':
                    /*
                        UE.getEditor('my_tweet',{
                            toolbars:[["link","emotion"]],
                            autoClearinitialContent:true, //编辑器获取焦点时时自动清空初始化时的内容
                            wordCount:true,                 //字数统计
                            maximumWords:140,
                            wordCountMsg : '已输入 {#count} 个字符，您还可以输入{#leave} 个',
                            wordOverFlowMsg : '<span style="color:red;">你输入的字符个数已经超出最大允许值，服务器可能会拒绝保存！</span>',
                            initialFrameHeight:70          //高度
                       });
                    */
                    $eavValue['value']='<div class="form-group"><div class="col-xs-12">
                        <textarea  '.$required.'  name="'.$eavValue['attribute_code'].'" id="'.$eavValue['attribute_code'].'" style="width: 100%;" >'
                        .$eavValue['value'].'</textarea></div><span class="help-inline">'.'</span></div>
                        <script type="text/javascript">var um = UM.getEditor(\''.$eavValue['attribute_code'].'\');</script>';
                    break;
                default:
                    $eavValue['value']='<div class="form-group"><div class="col-xs-6">
                                        <input type="text" name="'.$eavValue['attribute_code'].'" placeholder=""
                                         '.$required.' class="form-control" value="'.$eavValue['value'].'" ></div>
                                        <span class="help-inline">'.'</span></div>';
            }
            $editForm .= '<dt>'.$eavValue['frontend_label'].'</dt><dd>'.$eavValue['value'].'</dd>';
        }
        $editForm .= '<dt><button type="submit" class="btn btn-primary">保存</button></dt><dd></dd></form>';
        $editForm .= "<script type=\"text/javascript\">
                        $(document).ready(function() {
                            $('#attgroup".$attGroupId."').bootstrapValidator({fields: {".$validator."}});
                        });
                      </script>
                        </dl>
                    </div>";
        return $editForm;
    }

    public function viewForm($attGroupId){
        $viewForm = '<style>.dl-horizontal dt {margin-bottom: 10px;}</style>
                    <div class="table-responsive">
                        <dl class="dl-horizontal">';
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
                default:
            }
            $viewForm .= '<dt>'.$eavValue['frontend_label'].'</dt><dd>'.$eavValue['value'].'</dd>';
        }
        $viewForm.='<dt><a href="'.$this->currentCUrl.'view.php?id='.$this->entityId.'&gid='.$this->attGroupId.'&edit=1" >编辑</a></dt><dd></dd>
                        </dl>
                    </div>';
        return $viewForm;
    }
}