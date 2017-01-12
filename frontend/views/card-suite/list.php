<?php
use yii\helpers\Html;use yii\helpers\Url;
use yii\grid\GridView;
use common\models\Card ;
/* @var $this yii\web\View */
/* @var $searchModel common\models\CardSuiteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '卡套餐';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card-suite-index">

    <h1><?= Html::encode($this->title) ?></h1>


<table class="table">

  <tr>
  <td class="success">套餐</td>
  <td class="success">冲入时长</td>
  <td class="success">价格</td>
  <td class="success">出卡量</td>
  <td class="success">操作</td>
  </tr>
  
 <?php 
 foreach ($model as $key => $value) { ?>

  <tr>
  <td ><?=$value->tname?></td>
  <td ><?=Card::ref_period_lebels($value->period)?></td>
  <td ><?=$value->price?></td>
  <td ><?=$value->amount?></td>
  <td >
  <?= Html::a('下单', ['card-suite/ord'],  [
    'data'=>[
        'method' => 'post',
        'confirm' => '套餐:' .$value->tname . ';价格:' . $value->price . ';出卡量:' . $value->amount,
        'params'=>['id'=>$value->id],
    ],
    'class' => 'btn btn-default btn-sm'
]) ?>
  </td>
  </tr>
     
<?php
 }
 ?>
 

 
  
</table>


</div>
