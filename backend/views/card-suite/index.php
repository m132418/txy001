<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Card;
use common\models\RefAgents;
/* @var $this yii\web\View */
/* @var $searchModel common\models\CardSuiteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Card Suites';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card-suite-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Card Suite', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'tname',
            'desc',
//            'period',
            [
//                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                'attribute'=>'period',
                'filter'=>Card::ref_period_lebels(),
                'value' => function ($data) {
                    return Card::ref_period_lebels($data->period); // $data['name'] for array data, e.g. using SqlDataProvider.
                },
            ],
//            'req_level',
            [
//                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                'attribute'=>'req_level',
                'filter'=> RefAgents::ref_lebels(),
                'value' => function ($data) {
                    return  RefAgents::ref_lebels($data->req_level); // $data['name'] for array data, e.g. using SqlDataProvider.
                },
            ],




            'price',
             'amount',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
