<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Card ;
use common\models\RefAgents ;
/* @var $this yii\web\View */
/* @var $model common\models\CardSuite */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card-suite-form">

    <?php $form = ActiveForm::begin(); ?>



    <?= $form->field($model, 'tname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'desc')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'req_level')->textInput()->dropdownList(
        RefAgents::ref_lebels()           ,
        ['prompt'=>'选个级别']);

    ?>

    <?= $form->field($model, 'period')->textInput()->dropdownList(
            Card::ref_period_lebels()            ,
        ['prompt'=>'选个类型']);

    ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
