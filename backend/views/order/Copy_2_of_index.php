<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use common\models\CardSuite;
use common\models\User;
use common\models\Card;
// use common\models\RefAgents;
/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = '充值明细';
$this->params['breadcrumbs'][] = $this->title;
class PTotal {
    public static function pageTotal($provider, $fieldName)
    {
        $total=0;
        foreach($provider as $item){
            $total+=$item[$fieldName];
        }
        return $total;
    }
};
?>
<div class="order-index">

  
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
//         'showFooter'=>TRUE,
        'footerRowOptions'=>['style'=>'font-weight:bold;text-decoration:underline;background-color:#F4F4F4'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//             'id',
//             'pay_suite',
            
            
//             [
//             'attribute' => 'pay_suite',
//                 'format' => 'text'
//             ],
            
            
            [
            //                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
            'label'=>'支付套餐',
            'attribute'=> 'pay_suite',
            'filter'=> CardSuite::ref_lebels(),
            'value' => function ($data) {
                return    CardSuite::ref_lebel($data->pay_suite) ; // $data['name'] for array data, e.g. using SqlDataProvider.
            },
            ],
            
//             'howmany',
//             'howmuch',
            [
            //                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
            'label'=>'出卡量',
            //             'filter'=> RefAgents::ref_lebels(),
            'value' => function ($data) {
            return   $data->howmany ; // $data['name'] for array data, e.g. using SqlDataProvider.
            },
            'footer'=>PTotal::pageTotal($dataProvider->models,'howmany'),
            ],
            [
            //                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
            'label'=>'卡时长类型',
                'attribute'=>'period',
            'filter'=> Card::ref_period_lebels(),
            'value' => function ($data) {
            return  Card::ref_period_lebels($data->period)   ; // $data['name'] for array data, e.g. using SqlDataProvider.
            },
            ],
            [
            //                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
            'label'=>'冲入金额(单位:元)',
            //             'filter'=> RefAgents::ref_lebels(),
            'value' => function ($data) {
            return   $data->howmuch ; // $data['name'] for array data, e.g. using SqlDataProvider.
            },
//             'footer'=>PTotal::pageTotal($dataProvider->models,'howmuch'),
            ],
//             'whose',
            [
            'attribute'=>'whose',
                'filter'=> User::ref_lebels_exclude_appadmin(),
                'value' => function ($data) {
                    return   User::ref_lebel_exclude_appadmin($data->whose) ; // $data['name'] for array data, e.g. using SqlDataProvider.
            },
            ],
//             'is_payed',
//             [         
//             'label'=>'是否已经支付',            
//             'value' => function ($data) {
//             if ($data->is_payed == 0) {
//                 return "未支付" ;
//             }elseif ($data->is_payed == 1)
//             return "已支付" ;            
//             },
//             ],
//             [           
//             'label'=>'是否已发卡',           
//             'value' => function ($data) {            
//             if ($data->is_gen == 0) {
//                return "未发卡" ;
//             }elseif ($data->is_gen == 1)
//             return "已发卡" ;           
//             },
//             ],
            // 'payed_sn',
            // 'channel',
            // 'created_at',
            // 'updated_at',
            [             
            'attribute'=>'created_at',
                'value' => function ($data) {
                    return date('Y-m-d H:i:s', $data->created_at); // $data['name'] for array data, e.g. using SqlDataProvider.
            },
            ],
            
            [
            'class' => 'yii\grid\ActionColumn',
            'header'=>'详细',
            'template' => '{view}'
            ],
           
        ],
        
    ]); ?>
</div>
