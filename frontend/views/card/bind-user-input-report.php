<?php
use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Card;
use common\models\RefApp;
use yii\helpers\ArrayHelper;
use yii\helpers\Url ;
/* @var $this yii\web\View */
/* @var $searchModel common\models\CardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '充入用户';
$this->params['breadcrumbs'][] = [
    'label' => '返回',
    'url' => ['card/index'],
//    'template' => "<li style="float: right;">{link}</li>\n"
];
$this->params['breadcrumbs'][] = $this->title;

?>
<?=$msg?>