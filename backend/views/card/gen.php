<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\User;
use common\models\Card;
$this->title = '手动生卡';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card-gen">
    <h1><?= Html::encode($this->title) ?></h1>

   
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'card-gen']); ?>

                <?= $form->field($model, 'amt')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'uid')->dropDownList(ArrayHelper::map(User::find()->where(['not like','username','appadmin'])->orderBy('username')->asArray()->all()  , "id", "username")) ?>
                <?= $form->field($model, 'period')->dropDownList(Card::ref_period_lebels())  ?>


                <div class="form-group">
                    <?= Html::submitButton('生...', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
