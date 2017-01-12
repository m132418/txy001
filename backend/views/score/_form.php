<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\Score */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="score-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'value')->textInput() ?>

  

 <?= $form->field($model, 'bindto')->dropDownList(ArrayHelper::map(User::find()->where(['not like','username','appadmin'])->orderBy('username')->asArray()->all()  , "id", "username")) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '赠送' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
