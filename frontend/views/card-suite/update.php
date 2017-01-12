<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CardSuite */

$this->title = 'Update Card Suite: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Card Suites', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="card-suite-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
