<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CardSuite */

$this->title = 'Create Card Suite';
$this->params['breadcrumbs'][] = ['label' => 'Card Suites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card-suite-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
