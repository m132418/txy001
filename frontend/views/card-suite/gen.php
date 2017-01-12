<?php
use yii\helpers\Html;

$this->title = '生成卡结果';
$this->params['breadcrumbs'][] = [
    'label' => '卡列表',
    'url' => ['card/index'],
    //    'template' => "<li style="float: right;">{link}</li>\n"
];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-info">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-info">
        <?= nl2br(Html::encode($msg)) ?>
    </div>



</div>
