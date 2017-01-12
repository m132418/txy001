<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = '修改资料 ';
// $this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改资料';
?>
<div class="user-update">

  

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['disabled'=>'disabled']) ?>
    <?= $form->field($model, 'xingming')->textInput() ?>
    <?= $form->field($model, 'tel')->textInput() ?>
    <?= $form->field($model, 'id_card')->textInput() ?>
    <?= $form->field($model, 'qq')->textInput() ?>
     <?= $form->field($model, 'email')->textInput() ?>
   
 <?= $form->field($model, 'comp_misc')->textInput() ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>
