<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OpLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Op Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="op-log-index">



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//             ['class' => 'yii\grid\SerialColumn'],

            'id',
            'ipadd',
            'opr',
            'misc',
//             'created_at'
    [             
            'attribute'=>'created_at',
                'value' => function ($data) {
                if ($data->created_at) {
                     return date('Y-m-d H:i:s', $data->created_at);
                }else
                    return "-null-"; // $data['name'] for array data, e.g. using SqlDataProvider.
            },
            ],

//             ['class' => 'yii\grid\ActionColumn'],

        ],
    ]); ?>
</div>
