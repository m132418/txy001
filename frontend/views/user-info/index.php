<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Infos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-info-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User Info', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'phonenumber',
            'email:email',
            'user_name',
//            'password',
            // 'pastime',
            // 'status',
             'vip',
            // 'expire_time',
            // 'last_login',
            // 'create_time',

            ['class' => 'yii\grid\ActionColumn'],
//            [
//                'class' => 'yii\grid\ActionColumn',
//                'buttons' => [
//                    'view' => function ($url, $model) {
//                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url , ['class' => 'view', 'data-pjax' => '0']);
//                    },
//                ],
//            ]

        ],
    ]);




    ?>
</div>
