<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'tname',
//            'desc',
            'req_level',
            'period',
            // 'price',
            // 'amount',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
