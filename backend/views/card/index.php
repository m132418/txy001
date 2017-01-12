<?php
use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Card;
use common\models\RefApp;
use yii\helpers\ArrayHelper;
use yii\helpers\Url ;
use common\models\UserInfo;
use common\models\User;
/* @var $this yii\web\View */
/* @var $searchModel common\models\CardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cards';
$this->params['breadcrumbs'][] = $this->title;
// $refapp_arr =ArrayHelper::map(RefApp::find()->all(), 'id', 'appname') ;
// var_dump(ArrayHelper::getValue($uinfos, 41,'母鸡')) ;exit() ;
function myname($var){
    return   ArrayHelper::getValue($uinfos, $var,'母鸡');
}
?>
<div class="card-index">

  


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
                'filter'=>Card::ref_status_lebels(),
                'value' => function ($data) {
                    return Card::ref_status_lebels($data->status); // $data['name'] for array data, e.g. using SqlDataProvider.
                },
            ],
//            'period',
            [
//                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                'attribute'=>'period',
                'filter'=>Card::ref_period_lebels(),
                'value' => function ($data) {
                    return Card::ref_period_lebels($data->period); // $data['name'] for array data, e.g. using SqlDataProvider.
                },
            ],
            // 'price',
//             'created_at:datetime',
            [
           
            'attribute'=>'created_at',
            'value' => function ($data) {
                return date('Y-m-d H:i:s', $data->created_at); // $data['name'] for array data, e.g. using SqlDataProvider.
            },
            ],
            // 'updated_at',
//             'bind_uid',
            [
             
            'attribute'=>'bind_uid',
                'format' => 'raw',
                'value' => function ($data) {
//                 $u = UserInfo::findOne(['id'=>$data->bind_uid]) ;
//                     return $u->user_name ? $u->user_name : '空值'; // $data['name'] for array data, e.g. using SqlDataProvider.
//                     return $data->bind_uname;
                    return  UserInfo::ref_lebel($data->bind_uid) ;
//                     return $data->bind_uid ;
//                     $u = UserInfo::findOne(['id'=>149]) ;
//                     var_dump($u->user_name) ;
            },
            ],
            [             
            'attribute'=>'bind_at',
                'format' => 'raw',
                'value' => function ($data) {
                
                if ($data->bind_at) {
                     return date('Y-m-d H:i:s',$data->bind_at );
                }else 
                    return "-null-";                
               
            },
            ],
//             'whoissue',
            [
            'attribute'=>'whoissue',
                'filter'=> User::ref_lebels_exclude_appadmin(),
                'value' => function ($data) {
                return   User::ref_lebel_exclude_appadmin($data->whoissue) ; // $data['name'] for array data, e.g. using SqlDataProvider.
            },
            ],
            [
            'attribute'=>'status',
//             'format' => 'raw',
                'filter'=>[1=>"未使用",2=>"用过了"],
            'value' => function ($data) {
            
            if ($data->status == 1) {
            return "未使用";
            }else
                return "用过了";
                 
                },
                ],

//            ['class' => 'yii\grid\ActionColumn'],

//            ['class' => 'yii\grid\ActionColumn',
//               'template' => '{delete}',
//             ],

        ],
    ]);
    ?>
</div>
