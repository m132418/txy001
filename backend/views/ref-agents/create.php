<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\RefAgents */

$this->title = 'Create Ref Agents';
$this->params['breadcrumbs'][] = ['label' => 'Ref Agents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-agents-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
