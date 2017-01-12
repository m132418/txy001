<?php
use frontend\assets\AppAsset;
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
//             'id',
            'username',
            'xingming',
            'level',
            'id_card',
            'qq',
            'email:email',
            'tel',
            'comp_misc',
//             'created_at:datetime',
//             [
//             'attribute'=>'created_at',
//             'value' =>myname($model->created_at)
//             ],
//             'updated_at:datetime',

        ],
    ]) ?>
    
    

   

</div>
    <script src="http://echarts.baidu.com/build/dist/echarts.js"></script>
    <div class="row">
        <div id="chart1" style="height:400px" class="col-lg-6"> </div>
        <div id="chart2" style="height:400px" class="col-lg-6"> </div>
    </div>
        <?= $this->render('chart1', [
        'count_cards_all' => $count_cards_all,'id'=>$id
    ]) ?>
    </div>
        <?= $this->render('chart2', [
        'sum_2nd' => $sum_2nd,'id'=>$id
    ]) ?>