<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->params["company_name"],
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => '首页', 'url' => ['/site/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } elseif(\Yii::$app->user->can('appadmin'))  {
//        $menuItems[] = '<li>'
//            . Html::beginForm(['/site/logout'], 'post')
//            . Html::submitButton(
//                'Logout (' . Yii::$app->user->identity->username . ')',
//                ['class' => 'btn btn-link logout']
//            )
//            . Html::endForm()
//            . '</li>';
        $menuItems[] = ['label' => '公告', 'url' => ['/pub-bord']];
//         $menuItems[] = ['label' => '卡管理', 'url' => ['/card']];
        
        $menuItems[]=  [ 'label' => '卡管理',  'items' => [
            ['label' => '所有卡', 'url' => ['/card/index']],
            ['label' => '充值记录', 'url' => ['/order/index']],
            ['label' => '赠送卡', 'url' => ['/card/gen']],
            ['label' => '套餐', 'url' => ['/card-suite/index']],
           
        ],
        ];
        
//         $menuItems[] = ['label' => '充值明细', 'url' => ['/order']];
//         $menuItems[] = ['label' => '套餐', 'url' => ['/card-suite']];
//         $menuItems[] = ['label' => '代理商', 'url' => ['/user']];
        $menuItems[]=  [ 'label' => '代理商',  'items' => [
            ['label' => '账号', 'url' => ['/user/index']],            
            ['label' => '级别设定', 'url' => ['/ref-agents/index']],
            ['label' => '赠送积分', 'url' => ['/score/create']],
        ],
        ];
        
        
        
        
        $menuItems[]=  [ 'label' => '账户相关',  'items' => [
            ['label' => '改密', 'url' => ['/site/chgpwd']],
            ['label' => '操作记录', 'url' => ['/op-log/index']],
            
            ['label' => '登出(' .Yii::$app->user->identity->username . ')', 'url' => ['/site/logout'],'linkOptions' => ['data-method' => 'post']],
        ],
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::$app->params["company_name"]. date('Y') ?></p>

        <p class="pull-right"><?=Yii::$app->params["company_name"] . "开发"?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
