<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PubBordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '公告';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pub-bord-index">

    <h1><?= Html::encode($this->title) ?></h1>
    

    <p>
        <?= Html::a('创建公告', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//             'id',
            'title',
            'content:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
