<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CardSuite;
use common\models\Card;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '支付订单';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//         'filterModel' => $searchModel,
        'columns' => [
//             ['class' => 'yii\grid\SerialColumn'],

//             'id',
//             'pay_suite',
            
            
//             [
//             'attribute' => 'pay_suite',
//                 'format' => 'text'
//             ],
            
            
            [
            //                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
            'label'=>'支付套餐',
//             'filter'=> RefAgents::ref_lebels(),
            'value' => function ($data) {
                return    CardSuite::ref_lebels($data->pay_suite) ; // $data['name'] for array data, e.g. using SqlDataProvider.
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
            ],
            [
            //                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
            'label'=>'卡冲入时长',
            //             'filter'=> RefAgents::ref_lebels(),
            'value' => function ($data) {
            return  Card::ref_period_lebels($data->period)   ; // $data['name'] for array data, e.g. using SqlDataProvider.
            },
            ],
            [
            //                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
            'label'=>'应付金额(单位:元)',
            //             'filter'=> RefAgents::ref_lebels(),
            'value' => function ($data) {
            return   $data->howmuch ; // $data['name'] for array data, e.g. using SqlDataProvider.
            },
            ],
//             'whose',
//             'is_payed',
            [
            //                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
            'label'=>'是否已经支付',
            //             'filter'=> RefAgents::ref_lebels(),
            'value' => function ($data) {
            if ($data->is_payed == 0) {
                return "未支付" ;
            }elseif ($data->is_payed == 1)
            return "已支付" ;
            
            },
            ],
            [
            //                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
            'label'=>'是否已发卡',
            //             'filter'=> RefAgents::ref_lebels(),
            'value' => function ($data) {
            
            if ($data->is_gen == 0) {
               return "未发卡" ;
            }elseif ($data->is_gen == 1)
            return "已发卡" ;
            
            
            },
            ],
            // 'payed_sn',
            // 'channel',
            // 'created_at',
            // 'updated_at',

            [
            'class' => 'yii\grid\ActionColumn',
            'header'=>'详细',
            'template' => '{view}'
            ],
        ],
    ]); ?>
</div>
