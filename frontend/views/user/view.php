<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
function myname($var){
    return  date('Y-m-d H:i:s', $var);
}
?>
<div class="user-view">



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
//             'auth_key',
//             'password_hash',
//             'password_reset_token',
            'email:email',
            'tel',
//             'created_at:datetime',
            [
            'attribute'=>'created_at',
            'value' =>myname($model->created_at)
            ],
//             'updated_at:datetime',
            'level',
        ],
    ]) ?>

</div>
