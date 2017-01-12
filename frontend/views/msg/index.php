<?php
use yii\helpers\Url;
use yii\helpers\Html;


$this->title = '消息页面';
$this->params['breadcrumbs'][] = $this->title;
?>
<html>
    <head>
        <meta http-equiv="refresh" content="<?=$sec?>;url=<?=Url::to($url)?>" />
    </head>
    <body>
        <h4><?=$msg?></h4>
    
        <p>Redirecting in <?=$sec?> seconds...</p>
    </body>
</html>