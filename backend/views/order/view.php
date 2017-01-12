<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

// $this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '充值明细', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
function myname($var){
  return  date('Y-m-d H:i:s', $var); 
}
?>
<div class="order-view">





    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//             'id',
//             'pay_suite',
            [
            'attribute'=>'pay_suite',
//             'label' => 'Unit',
                'value' => $model->suitename
                ],
            'howmany',
            'howmuch',
//             'whose',
//             'is_payed',
            [
            'attribute'=>'is_payed',
            'value' => $model->payed
                ],
            'payed_sn',
            
            'channelname',
            'buyer_id',
            'buyer_email',
            [
            'attribute'=>'created_at',          
            'value' =>myname($model->created_at)             
                ],

        ],
    ]) ?>
    
    <?php 
/*     if ($model->is_payed == 1 && $model->is_gen == 0) {
        echo Html::a('生卡...', [
            'card-suite/gen'
        ], [
            'data' => [
                'method' => 'post',
                'confirm' => '你确认?' ,
                'params' => [
                    'id' => $model->id
                ]
            ],
            'class' => 'btn btn-default btn-sm'
        ]);
    } */
    ?>

</div>
