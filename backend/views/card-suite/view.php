<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CardSuite */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Card Suites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card-suite-view">



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'tname',
            'desc',
            'period',
            'req_level',
            'price',
            'amount',
        ],
    ]) ?>

</div>
