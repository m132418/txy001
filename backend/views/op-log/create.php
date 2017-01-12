<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\OpLog */

$this->title = 'Create Op Log';
$this->params['breadcrumbs'][] = ['label' => 'Op Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="op-log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
