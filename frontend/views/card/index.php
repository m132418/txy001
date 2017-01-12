<?php
use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Card;
use common\models\RefApp;
use yii\helpers\ArrayHelper;
use common\components\MyHelpers;
use yii\helpers\Url ;
use common\models\UserInfo;
/* @var $this yii\web\View */
/* @var $searchModel common\models\CardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cards';
$this->params['breadcrumbs'][] = $this->title;
// $refapp_arr =ArrayHelper::map(RefApp::find()->all(), 'id', 'appname') ;


?>
<div class="card-index">

  

     <?= Html::a('导出所有未使用的卡', ['xlsx/cards'],  [
    'data'=>[
        'method' => 'post',
//         'confirm' => '套餐:' .$value->tname . ';价格:' . $value->price . ';出卡量:' . $value->amount,
//         'params'=>['id'=>1],
    ],
    'class' => 'btn btn-default btn-sm'
]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'sn',
//            'refapp',
//             [

//                 'attribute'=>'refapp',
//                 'filter'=>$refapp_arr,
//                 'value' => function ($data) {
//                     $refapp_arr =   ArrayHelper::map(RefApp::find()->all(), 'id', 'appname') ;

//                     return ArrayHelper::getValue($refapp_arr, $data->refapp);
//                 },
//             ],
//            'status',
            [
//                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                'attribute'=>'status',
//                 'filter'=>Card::ref_status_lebels(),    
                    'filter'=> Html::activeDropDownList($searchModel, 'status',Card::ref_status_lebels() ,['class'=>'form-control','prompt' => '全部']),
                'value' => function ($data) {
                    return Card::ref_status_lebels($data->status); // $data['name'] for array data, e.g. using SqlDataProvider.
                },
            ],
//            'period',
            [
//                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                'attribute'=>'period',
//                 'filter'=>Card::ref_period_lebels(),
                'filter'=> Html::activeDropDownList($searchModel, 'period',Card::ref_period_lebels(),['class'=>'form-control','prompt' => '全部']),
                'value' => function ($data) {
                    return Card::ref_period_lebels($data->period); // $data['name'] for array data, e.g. using SqlDataProvider.
                },
            ],
            // 'price',
//             'created_at:datetime',
            [
           
            'label'=>'创建于',
            'value' => function ($data) {
                return date('Y-m-d H:i:s', $data->created_at); // $data['name'] for array data, e.g. using SqlDataProvider.
            },
            ],
            // 'updated_at',
//             'bind_uid',
            [
             
            'attribute'=>'bind_uid',
                'format' => 'raw',
                'filter'=> Html::activeDropDownList($searchModel, 'bind_uid',UserInfo::ref_lebels(),['class'=>'form-control','prompt' => '全部']),
                'value' => function ($data) {
//                 $u = UserInfo::findOne(['id'=>$data->bind_uid]) ;
//                     return $u->user_name ? $u->user_name : '空值'; // $data['name'] for array data, e.g. using SqlDataProvider.
                    return $data->bind_uname ;
//                     return $data->bind_uid ;
//                     $u = UserInfo::findOne(['id'=>149]) ;
//                     var_dump($u->user_name) ;
            },
            ],
            [             
            'label'=>'使用时刻',
                'format' => 'raw',
                'value' => function ($data) {
                
                if ($data->bind_at) {
                     return date('Y-m-d H:i:s',$data->bind_at );
                }else 
                    return "-null-";                
               
            },
            ],
//             'whoissue',

//            ['class' => 'yii\grid\ActionColumn'],

            [
                'class' => 'yii\grid\ActionColumn',
                'urlCreator' => function( $action, $model, $key, $index ){
                    if ($action == "view") {
                        return Url::to(['bind-user-input', 'cid' => $key,'vcd'=> MyHelpers::check_vcd("".$key)]);
                    }
                },
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-log-in"></span>', $url , ['class' => 'view', 'data-pjax' => '0']);
                    },
                ],
                'template' => '{view}',
            ]

        ],
    ]);
    $this->registerJs(
        "$(document).on('ready pjax:success', function() {  // 'pjax:success' use if you have used pjax
    $('.view').click(function(e){
       e.preventDefault();
       $('#pModal').modal('show')
                  .find('.modal-content')
                  .load($(this).attr('href'));
   });
});
");

    yii\bootstrap\Modal::begin([
        'header'=>'<h4>卡注入用户</h4>',
        'id'=>'pModal',
//        'size'=>'modal-lg',
    ]);
    yii\bootstrap\Modal::end();

    ?>
</div>
