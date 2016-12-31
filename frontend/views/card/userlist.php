<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url ;
/* @var $this yii\web\View */
/* @var $searchModel common\models\UserInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '绑用户';
$this->params['breadcrumbs'][] = [
    'label' => '卡列表',
    'url' => ['card/index'],
//    'template' => "<li style="float: right;">{link}</li>\n"
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-info-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

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

//            ['class' => 'yii\grid\ActionColumn'],
//            [
//                'class' => 'yii\grid\ActionColumn',
//                'buttons' => [
//                    'view' => function ($url, $model) {
//                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url , ['class' => 'view', 'data-pjax' => '0']);
//                    },
//                ],
//                'template' => '{update}',
//            ]
            [
                'class' => 'yii\grid\ActionColumn',
                'urlCreator' => function( $action, $model, $key, $index ){
                    if ($action == "diy") {
                        return Url::to(['bind-user', 'key' => $key ,'cid'=>$_GET["cid"]]);
                    }
                },
//                'template' => '{user-view:view} {user-update:update} {user-del:delete} {user-diy-btn:diy}',
                'buttons' => [
                    // 自定义按钮
                    'diy' => function ($url, $model, $key) {
                        $options = [
                            'title' => "把卡冲入该用户",
                            'aria-label' => Yii::t('yii', 'Update'),
//                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-cloud-download"></span>', $url, $options);
                    },
                ],
                'template' => '{diy}',
            ]

        ],
    ]);




    ?>
</div>
