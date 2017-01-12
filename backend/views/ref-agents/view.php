<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\RefAgents */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '代理商级别', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-agents-view">

    <h1><?= Html::encode($this->title) ?></h1>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'desc',
            'set_point',
        ],
    ]) ?>

</div>
