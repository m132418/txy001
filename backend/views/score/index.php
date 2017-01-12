<?php
use common\models\User ;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ScoreSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '积分';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="score-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('赠送积分', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//             ['class' => 'yii\grid\SerialColumn'],

//             'id',
            'value',
//             'add_type',
            [
            //                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default          
            'attribute'=>'add_type',
            'filter'=> [0=>"充值",1=>"赠送"],
            'value' => function ($data) {
            
              if ($data->add_type == 1) {
                  return "赠送";
              }elseif ($data->add_type == 0) 
                  return "充值";
            
            },
            ],
//             'bindto',
            [
            'attribute'=>'bindto',
                'filter'=> User::ref_lebels2(),
                'value' => function ($data) {
                return   User::ref_lebel_exclude_appadmin($data->bindto) ; // $data['name'] for array data, e.g. using SqlDataProvider.
            },
            ],
//             'created_at',
             [             
            'attribute'=>'created_at',
                'value' => function ($data) {
                    return date('Y-m-d H:i:s', $data->created_at); // $data['name'] for array data, e.g. using SqlDataProvider.
            },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
