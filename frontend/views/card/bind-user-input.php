<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '冲卡给用户操作';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>



    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'bind-user-input']); ?>
            <?= $form->field($model, 'cardsn')->textInput(['disabled'=>'disabled']) ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('冲入', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
