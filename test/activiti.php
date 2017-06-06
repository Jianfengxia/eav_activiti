<?php
/**
 * Created by PhpStorm.
 * User: jianfeng.xia
 * Date: 2016/7/19
 * Time: 9:40
 */

require 'layout.php';

function restApi($method,$url){
    $response = \Httpful\Request::$method($url)->authenticateWith('kermit', 'kermit');
    return $response;
}

$baseUrl = "http://10.1.134.129:8080/activiti-rest/service/";


//申请新项目立项
//$response = restApi('post',$baseUrl.'runtime/process-instances')->sendsJson()->body('{ "processDefinitionId":"pm1:19:6746","businessKey":"myBusinessKey"}')->send();
/*
//项目列表
$response = restApi('post',$baseUrl.'query/process-instances')->sendsJson()->body('{ "processDefinitionKey":"pm1"}')->send();

//获得项目的参与者 GET runtime/process-instances/{processInstanceId}/identitylinks
$response = restApi('get',$baseUrl.'runtime/process-instances/6222/identitylinks')->send();

//列出流程实例的变量 GET runtime/process-instances/{processInstanceId}/variables
$response = restApi('get',$baseUrl.'runtime/process-instances/6222/variables')->send();


$response = restApi('get',$baseUrl.'runtime/process-instances/2737/identitylinks')->send();
echo 'runtime/process-instances/8655';
var_dump($response->body);
//sid-02AD2039-C082-4597-A1AA-070D15182624/activities
$response = restApi('post',$baseUrl.'query/executions')->sendsJson()->body('{"processInstanceId" : 2737}')->send();
echo 'query/executions';
var_dump($response->body);
$response = restApi('get',$baseUrl.'runtime/executions/8655')->send();
echo 'runtime/executions/8655';
var_dump($response->body);
$response = restApi('get',$baseUrl.'runtime/tasks/8641')->send();
echo 'runtime/tasks/8659';
var_dump($response->body);
$response = restApi('post',$baseUrl.'query/tasks')->sendsJson()->body('{"processInstanceId" : 2737}')->send();
echo 'query/tasks';
var_dump($response->body->data);
*/

$response = restApi('get',$baseUrl.'runtime/tasks/8665/identitylinks')->send();
echo 'runtime/tasks/8659';

//获取任务 GET runtime/tasks/{taskId}
//$response = restApi('get',$baseUrl.'runtime/tasks/6406')->send();
//var_dump($response->body->data);
//任务列表 GET runtime/tasks
//$response = restApi('get',$baseUrl.'runtime/tasks')->send();

//查询任务 POST query/tasks   [{ "name":"id",   "value" : 6746,"operation" : "equals","type" : "integer"  }]
//$response = restApi('post',$baseUrl.'query/tasks')->sendsJson()->body('{"processInstanceId" : 8655}')->send();

//更新任务 PUT runtime/tasks/{taskId}

//操作任务 POST runtime/tasks/{taskId}

//删除任务 DELETE runtime/tasks/{taskId}?cascadeHistory={cascadeHistory}&deleteReason={deleteReason}

//获得任务的变量 GET runtime/tasks/{taskId}/variables?scope={scope}

//获取任务的一个变量 GET runtime/tasks/{taskId}/variables/{variableName}?scope={scope}

//获取变量的二进制数据 GET runtime/tasks/{taskId}/variables/{variableName}/data?scope={scope}

//创建任务变量 POST runtime/tasks/{taskId}/variables

//创建二进制任务变量 POST runtime/tasks/{taskId}/variables

//更新任务的一个已有变量 PUT runtime/tasks/{taskId}/variables/{variableName}

//更新一个二进制任务变量 PUT runtime/tasks/{taskId}/variables/{variableName}

//删除任务变量 DELETE runtime/tasks/{taskId}/variables/{variableName}?scope={scope}

//删除任务的所有局部变量 DELETE runtime/tasks/{taskId}/variables

//获得任务的所有IdentityLink GET runtime/tasks/{taskId}/identitylinks

//获得一个任务的所有组或用户的IdentityLink GET runtime/tasks/{taskId}/identitylinks/users | GET runtime/tasks/{taskId}/identitylinks/groups

//获得一个任务的一个IdentityLink GET runtime/tasks/{taskId}/identitylinks/{family}/{identityId}/{type}

//为任务创建一个IdentityLink POST runtime/tasks/{taskId}/identitylinks

//删除任务的一个IdentityLink DELETE runtime/tasks/{taskId}/identitylinks/{family}/{identityId}/{type}

//为任务创建评论 POST runtime/tasks/{taskId}/comments

//获得任务的所有评论 GET runtime/tasks/{taskId}/comments

//获得任务的一个评论 GET runtime/tasks/{taskId}/comments/{commentId}

//删除任务的一条评论 DELETE runtime/tasks/{taskId}/comments/{commentId}

//获得任务的所有事件 GET runtime/tasks/{taskId}/events

//获得任务的一个事件 GET runtime/tasks/{taskId}/events/{eventId}

//为任务创建一个附件，包含外部资源的链接 POST runtime/tasks/{taskId}/attachments

//为任务创建一个附件，包含附件文件 POST runtime/tasks/{taskId}/attachments

//获得任务的所有附件 GET runtime/tasks/{taskId}/attachments

//获得任务的一个附件 GET runtime/tasks/{taskId}/attachments/{attachmentId}

//获取附件的内容 GET runtime/tasks/{taskId}/attachment/{attachmentId}/content

//删除任务的一个附件 DELETE runtime/tasks/{taskId}/attachments/{attachmentId}



//部署 GET repository/deployments
//$response = restApi('get',$baseUrl.'repository/deployments')->expectsJson()->send();

//获得一个部署 GET repository/deployments/{deploymentId}
//$response = restApi('get',$baseUrl.'repository/deployments/1273')->expectsJson()->send();

//创建新部署 POST repository/deployments
//$response = restApi('post',$baseUrl.'repository/deployments')->body('<xml><name>ddddd</name></xml>')->sendsXml()->send();

//删除部署 DELETE repository/deployments/{deploymentId}
//$response = restApi('delete',$baseUrl.'repository/deployments/1308')->expectsJson()->send();

//列出部署内的资源 GET repository/deployments/{deploymentId}/resources
//$response = restApi('get',$baseUrl.'repository/deployments/1316/resources')->expectsJson()->send();

//获取部署资源 GET repository/deployments/{deploymentId}/resources/{resourceId}
//$response = restApi('get',$baseUrl.'repository/deployments/1316/resources/'.('test-Rest-API.bpmn20.xml'))->send();

//获取部署资源的内容 GET repository/deployments/{deploymentId}/resourcedata/{resourceId}
//$response = restApi('get',$baseUrl.'repository/deployments/1316/resourcedata/'.('test-Rest-API.bpmn20.xml'))->send();

//流程定义列表 GET repository/process-definitions
//$response = restApi('get',$baseUrl.'repository/process-definitions')->send();

//获得一个流程定义 GET repository/process-definitions/{processDefinitionId}
//$response = restApi('get',$baseUrl.'repository/process-definitions/process:3:1326')->send();

//更新流程定义的分类 PUT repository/process-definitions/{processDefinitionId}
//$response = restApi('put',$baseUrl.'repository/process-definitions/process:3:1326')->sendsJson()->body('{"category" : "testcategory"}')->send();

//获得一个流程定义的资源内容 GET repository/process-definitions/{processDefinitionId}/resourcedata
//$response = restApi('get',$baseUrl.'repository/process-definitions/process:3:1326/resourcedata')->send();

//获得流程定义的BPMN模型 GET repository/process-definitions/{processDefinitionId}/model
//$response = restApi('get',$baseUrl.'repository/process-definitions/pm1:21:8576/model')->send();

//暂停流程定义 PUT repository/process-definitions/{processDefinitionId}
//$response = restApi('put',$baseUrl.'repository/process-definitions/process:3:1326')->sendsJson()->body('{"action" : "suspend","includeProcessInstances" : "false","date" : "2013-04-15T00:42:12Z"}')->send();

//激活流程定义 PUT repository/process-definitions/{processDefinitionId}
//$response = restApi('put',$baseUrl.'repository/process-definitions/process:3:1326')->sendsJson()->body('{"action" : "activate","includeProcessInstances" : "true","date" : "2013-04-15T00:42:12Z"}')->send();

//获得流程定义的所有候选启动者 GET repository/process-definitions/{processDefinitionId}/identitylinks
//$response = restApi('get',$baseUrl.'repository/process-definitions/process:3:1326/identitylinks')->send();

//为流程定义添加一个候选启动者 POST repository/process-definitions/{processDefinitionId}/identitylinks  //"user" : "kermit", "group" : "sales" 二选一
//$response = restApi('post',$baseUrl.'repository/process-definitions/process:3:1326/identitylinks')->body('{"group" : "sales"}')->sendsJson()->send();

//删除流程定义的候选启动者 DELETE repository/process-definitions/{processDefinitionId}/identitylinks/{family}/{identityId} family(users 或 groups)
//$response = restApi('delete',$baseUrl.'repository/process-definitions/process:3:1326/identitylinks/groups/sales')->send();

//获得模型列表 GET repository/models
//$response = restApi('get',$baseUrl.'repository/models')->send();

//获得一个模型 GET repository/models/{modelId}
//$response = restApi('get',$baseUrl.'repository/models/1320')->send();

//更新模型 PUT repository/models/{modelId}
//$response = restApi('put',$baseUrl.'repository/models/1320')->sendsJson()->body('{"name":"Model name",   "key":"Model key",   "category":"Modelcategory",   "version":2,   "metaInfo":"Model metainfo",  "tenantId":"updatedTenant"}')->send();

//新建模型 POST repository/models
//$response = restApi('post',$baseUrl.'repository/models')->sendsJson()->body('{"name":"22222",   "key":"Model key",   "category":"Modelcategory",   "version":2,   "metaInfo":"Model metainfo", "deploymentId":"23", "tenantId":"updatedTenant"}')->send();

//删除模型 DELETE repository/models/{modelId}
//$response = restApi('delete',$baseUrl.'repository/models/2580')->send();

//获得模型的可编译源码 GET repository/models/{modelId}/source
//$response = restApi('get',$baseUrl.'repository/models/1320/source')->send();

//设置模型的附加可编辑源码 GET repository/models/{modelId}/source-extra
//$response = restApi('get',$baseUrl.'repository/models/1320/source-extra')->send();

//获得流程实例列表 GET runtime/process-instances
//$response = restApi('get',$baseUrl.'runtime/process-instances')->send();

//获得流程实例 GET runtime/process-instances/{processInstanceId}
//$response = restApi('get',$baseUrl.'runtime/process-instances/1397')->send();

//激活或挂起流程实例 PUT runtime/process-instances/{processInstanceId}  "action":"suspend" or "activate"
//$response = restApi('put',$baseUrl.'runtime/process-instances/188')->sendsJson()->body('{"action":"suspend"}')->send();

//删除流程实例 DELETE runtime/process-instances/{processInstanceId}
//$response = restApi('delete',$baseUrl.'runtime/process-instances/188')->send();

//启动流程实例 POST runtime/process-instances "processDefinitionId":"oneTaskProcess:1:158", or  "processDefinitionKey":"oneTaskProcess", or "message":"newOrderMessage", | when processDefinitionKey and message "tenantId": "tenant1",
//$response = restApi('post',$baseUrl.'runtime/process-instances')->sendsJson()->body('{ "processDefinitionId":"process:3:1326","businessKey":"myBusinessKey",    "variables": [     { "name":"myVar",       "value":"This is a variable"    }   ]}')->send();

//查询流程实例 POST query/process-instances | operation可以是以下值： equals, notEquals, equalsIgnoreCase, notEqualsIgnoreCase, lessThan, greaterThan, lessThanOrEquals, greaterThanOrEquals和like。  |  string,short,integer,long,double,boolean,date
//$response = restApi('post',$baseUrl.'query/process-instances')->sendsJson()->body('{ "processDefinitionKey":"process", "variables": [{ "name":"id",   "value" : 2645,"operation" : "equals","type" : "integer"   }   ]}')->send();

//获得流程实例 GET runtime/process-instances/{processInstanceId}
//$response = restApi('get',$baseUrl.'runtime/process-instances/188')->send();

//获得流程实例的参与者 GET runtime/process-instances/{processInstanceId}/identitylinks
//$response = restApi('get',$baseUrl.'runtime/process-instances/188/identitylinks')->send();

//为流程实例添加一个参与者 POST runtime/process-instances/{processInstanceId}/identitylinks | {"userId":"kermit", "type":"participant"}
//$response = restApi('post',$baseUrl.'runtime/process-instances/188/identitylinks')->sendsJson()->body('{"user":"keadfrmit", "type":"participant"}')->send();

//删除一个流程实例的参与者 DELETE runtime/process-instances/{processInstanceId}/identitylinks/users/{userId}/{type}
//$response = restApi('delete',$baseUrl.'runtime/process-instances/188/identitylinks/users/kermit/participant')->send();

//列出流程实例的变量 GET runtime/process-instances/{processInstanceId}/variables
//$response = restApi('get',$baseUrl.'runtime/process-instances/2717/variables')->send();

//获得流程实例的一个变量 GET runtime/process-instances/{processInstanceId}/variables/{variableName}
//$response = restApi('get',$baseUrl.'runtime/process-instances/2717/variables/new_property_2')->send();

//为流程实例添加一个参与者 POST/PUT runtime/process-instances/{processInstanceId}/variables
//$response = restApi('post',$baseUrl.'runtime/process-instances/2717/variables')->sendsJson()->body('[{"name":"intProcVar","type":"integer","value":123},.....]')->send();

//更新一个流程实例变量 PUT runtime/process-instances/{processInstanceId}/variables/{variableName}
//$response = restApi('put',$baseUrl.'runtime/process-instances/2717/variables/new_property_2')->sendsJson()->body('{"name":"intProcVar","type":"integer","value":123}')->send();

//创建一个新的二进制流程变量 POST runtime/process-instances/{processInstanceId}/variables
//$response = restApi('post',$baseUrl.'runtime/process-instances/2717/variables')->sendsJson()->body('{"name":"intProcVar","type":"integer","value":123}')->send();

//更新一个新的二进制流程变量 PUT runtime/process-instances/{processInstanceId}/variables
//$response = restApi('put',$baseUrl.'runtime/process-instances/2717/variables')->sendsJson()->body('{"name":"intProcVar","type":"integer","value":123}')->send();

//获取一个分支 GET runtime/executions/{executionId}

//对分支执行操作 PUT runtime/executions/{executionId}

//获得一个分支的所有活动节点 GET runtime/executions/{executionId}/activities

//获取分支列表 GET runtime/executions

//查询分支 POST query/executions

//获取分支的变量列表 GET runtime/executions/{executionId}/variables?scope={scope}

//获得分支的一个变量 GET runtime/executions/{executionId}/variables/{variableName}?scope={scope}

//新建（或更新）分支变量 POST/PUT runtime/executions/{executionId}/variables

//更新分支变量 PUT runtime/executions/{executionId}/variables/{variableName}

//创建一个二进制变量 POST runtime/executions/{executionId}/variables

//更新已经已存在的二进制分支变量 PUT runtime/executions/{executionId}/variables/{variableName}

//获取任务 GET runtime/tasks/{taskId}

//任务列表 GET runtime/tasks

//查询任务 POST query/tasks

//更新任务 PUT runtime/tasks/{taskId}

//操作任务 POST runtime/tasks/{taskId}

//删除任务 DELETE runtime/tasks/{taskId}?cascadeHistory={cascadeHistory}&deleteReason={deleteReason}

//获得任务的变量 GET runtime/tasks/{taskId}/variables?scope={scope}

//获取任务的一个变量 GET runtime/tasks/{taskId}/variables/{variableName}?scope={scope}

//获取变量的二进制数据 GET runtime/tasks/{taskId}/variables/{variableName}/data?scope={scope}

//创建任务变量 POST runtime/tasks/{taskId}/variables

//创建二进制任务变量 POST runtime/tasks/{taskId}/variables

//更新任务的一个已有变量 PUT runtime/tasks/{taskId}/variables/{variableName}

//更新一个二进制任务变量 PUT runtime/tasks/{taskId}/variables/{variableName}

//删除任务变量 DELETE runtime/tasks/{taskId}/variables/{variableName}?scope={scope}

//删除任务的所有局部变量 DELETE runtime/tasks/{taskId}/variables

//获得任务的所有IdentityLink GET runtime/tasks/{taskId}/identitylinks

//获得一个任务的所有组或用户的IdentityLink GET runtime/tasks/{taskId}/identitylinks/users | GET runtime/tasks/{taskId}/identitylinks/groups

//获得一个任务的一个IdentityLink GET runtime/tasks/{taskId}/identitylinks/{family}/{identityId}/{type}

//为任务创建一个IdentityLink POST runtime/tasks/{taskId}/identitylinks

//删除任务的一个IdentityLink DELETE runtime/tasks/{taskId}/identitylinks/{family}/{identityId}/{type}

//为任务创建评论 POST runtime/tasks/{taskId}/comments

//获得任务的所有评论 GET runtime/tasks/{taskId}/comments

//获得任务的一个评论 GET runtime/tasks/{taskId}/comments/{commentId}

//删除任务的一条评论 DELETE runtime/tasks/{taskId}/comments/{commentId}

//获得任务的所有事件 GET runtime/tasks/{taskId}/events

//获得任务的一个事件 GET runtime/tasks/{taskId}/events/{eventId}

//为任务创建一个附件，包含外部资源的链接 POST runtime/tasks/{taskId}/attachments

//为任务创建一个附件，包含附件文件 POST runtime/tasks/{taskId}/attachments

//获得任务的所有附件 GET runtime/tasks/{taskId}/attachments

//获得任务的一个附件 GET runtime/tasks/{taskId}/attachments/{attachmentId}

//获取附件的内容 GET runtime/tasks/{taskId}/attachment/{attachmentId}/content

//删除任务的一个附件 DELETE runtime/tasks/{taskId}/attachments/{attachmentId}

//获得历史流程实例 GET history/historic-process-instances/{processInstanceId}

//历史流程实例列表 GET history/historic-process-instances

//查询历史流程实例 POST query/historic-process-instances

//删除历史流程实例 DELETE history/historic-process-instances/{processInstanceId}

//获取历史流程实例的IdentityLink GET history/historic-process-instance/{processInstanceId}/identitylinks

//获取历史流程实例变量的二进制数据 GET history/historic-process-instances/{processInstanceId}/variables/{variableName}/data

//为历史流程实例创建一条新评论 POST history/historic-process-instances/{processInstanceId}/comments

//获得一个历史流程实例的所有评论 GET history/historic-process-instances/{processInstanceId}/comments

//获得历史流程实例的一条评论 GET history/historic-process-instances/{processInstanceId}/comments/{commentId}

//删除历史流程实例的一条评论 DELETE history/historic-process-instances/{processInstanceId}/comments/{commentId}

//获得单独历史任务实例 GET history/historic-task-instances/{taskId}

//获取历史任务实例 GET history/historic-task-instances

//查询历史任务实例 POST query/historic-task-instances

//删除历史任务实例 DELETE history/historic-task-instances/{taskId}

//获得历史任务实例的IdentityLink GET history/historic-task-instance/{taskId}/identitylinks

//获取历史任务实例变量的二进制值 GET history/historic-task-instances/{taskId}/variables/{variableName}/data

//获取历史活动实例 GET history/historic-activity-instances

//查询历史活动实例 POST query/historic-activity-instances

//查询历史变量实例 POST query/historic-variable-instances

//获取历史任务实例变量的二进制值 GET history/historic-variable-instances/{varInstanceId}/data

//获取历史细节 GET history/historic-detail

//查询历史细节 POST query/historic-detail

//获取历史细节变量的二进制数据 GET history/historic-detail/{detailId}/data

//获取表单数据 GET form/form-data

//提交任务表单数据 POST form/form-data

//接收信号事件 POST runtime/signals

//获取一个作业 GET management/jobs/{jobId}

//获得一个用户 GET identity/users/{userId}

//获取用户列表 GET identity/users

//获取群组列表 GET identity/groups

//为群组添加一个成员 POST identity/groups/{groupId}/members

var_dump($response->body);//
