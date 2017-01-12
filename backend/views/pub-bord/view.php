<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\PubBord */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '公告', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pub-bord-view">

    <h1><?= Html::encode($this->title) ?></h1>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'content:ntext',
        ],
    ]) ?>

</div>
