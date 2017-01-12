<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pay_suite')->textInput() ?>

    <?= $form->field($model, 'howmany')->textInput() ?>

    <?= $form->field($model, 'howmuch')->textInput() ?>

    <?= $form->field($model, 'whose')->textInput() ?>

    <?= $form->field($model, 'is_payed')->textInput() ?>

    <?= $form->field($model, 'payed_sn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'channel')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
