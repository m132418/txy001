<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Card */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//$var = User::findOne(['id'=>]);
?>
<div class="card-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'sn',
//            'refapp',
            [                      // the owner name of the model
                'label' => '参照系统',
                'value' => $model->ref_app->appname,
            ],
//            'status',
            [                      // the owner name of the model
                'label' => '参照系统',
                'value' => $model->status == 1 ? "未使用":"已使用",
            ],
//            'period',
            [                      // the owner name of the model
                'label' => '卡时长类型',
                'value' => $model->periodlable ,
            ],
//            'price',
            'created_at:datetime',

//            'updated_at',
            'bind_at:datetime',

//            'bind_uid',
            [                      // the owner name of the model
                'label' => '使用用户',
                'value' => $model->user_info->user_name,
            ],

        ],
    ]) ?>

</div>
