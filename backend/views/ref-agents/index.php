<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RefAgentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '代理商级别';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-agents-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ref Agents', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//             ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'desc',
            'set_point',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
