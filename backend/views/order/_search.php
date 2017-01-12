<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datetimepicker\DateTimePicker;
/* @var $this yii\web\View */
/* @var $model common\models\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    

    

    <?php // echo $form->field($model, 'updated_at') ?>
    <?php 
    echo yii\jui\DatePicker::widget([
        'model' => $model,
        'attribute' => 'temp1',
        'language' => 'zh-CN',
        'dateFormat' => 'yyyy-MM-dd',
    ]);
    ?>
    
    
        <?php 
    echo yii\jui\DatePicker::widget([
        'model' => $model,
        'attribute' => 'temp2',
        'language' => 'zh-CN',
        'dateFormat' => 'yyyy-MM-dd',
    ]);
   echo Html::submitButton('查询', ['class' => 'btn btn-primary']) ;
    echo Html::resetButton('重置', ['class' => 'btn btn-default']) ;
    ?>
  

    <?php ActiveForm::end(); ?>

</div>
