<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Score */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Scores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="score-view">

  
  

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'value',
            'add_type',
            'bindto',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
