<?php
use yii\helpers\Html;
// use yii\grid\GridView;
use common\models\Card;
use common\models\RefApp;
use yii\helpers\ArrayHelper;
use yii\helpers\Url ;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel common\models\CardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cards';
$this->params['breadcrumbs'][] = $this->title;
$refapp_arr =ArrayHelper::map(RefApp::find()->all(), 'id', 'appname') ;
?>
<div class="card-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php 
    
   
    $gridColumns = [
        ['class' => 'kartik\grid\SerialColumn'],
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'name',
            'pageSummary' => 'Page Total',
            'vAlign'=>'middle',
            'headerOptions'=>['class'=>'kv-sticky-column'],
            'contentOptions'=>['class'=>'kv-sticky-column'],
            'editableOptions'=>['header'=>'Name', 'size'=>'md']
        ],
        [
            'attribute'=>'color',
            'value'=>function ($model, $key, $index, $widget) {
                return "<span class='badge' style='background-color: {$model->color}'> </span>  <code>" .
                $model->color . '</code>';
            },
            'filterType'=>GridView::FILTER_COLOR,
            'vAlign'=>'middle',
            'format'=>'raw',
            'width'=>'150px',
            'noWrap'=>true
            ],
            [
                'class'=>'kartik\grid\BooleanColumn',
                'attribute'=>'status',
                'vAlign'=>'middle',
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'dropdown' => true,
                'vAlign'=>'middle',
                'urlCreator' => function($action, $model, $key, $index) { return '#'; },
                'viewOptions'=>['title'=>'viewMsg', 'data-toggle'=>'tooltip'],
                'updateOptions'=>['title'=>'updateMsg', 'data-toggle'=>'tooltip'],
                'deleteOptions'=>['title'=>'deleteMsg', 'data-toggle'=>'tooltip'],
                ],
                ['class' => 'kartik\grid\CheckboxColumn']
                ];
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'containerOptions' => ['style'=>'overflow: auto'], // only set when $responsive = false
        'beforeHeader'=>[
            [
                'columns'=>[
                    ['content'=>'Header Before 1', 'options'=>['colspan'=>4, 'class'=>'text-center warning']],
                    ['content'=>'Header Before 2', 'options'=>['colspan'=>4, 'class'=>'text-center warning']],
                    ['content'=>'Header Before 3', 'options'=>['colspan'=>3, 'class'=>'text-center warning']],
                ],
                'options'=>['class'=>'skip-export'] // remove this row from export
            ]
        ],
        'toolbar' =>  [
            ['content'=>
                Html::button('&lt;i class="glyphicon glyphicon-plus">&lt;/i>', ['type'=>'button', 'title'=>Yii::t('kvgrid', 'Add Book'), 'class'=>'btn btn-success', 'onclick'=>'alert("This will launch the book creation form.\n\nDisabled for this demo!");']) . ' '.
                Html::a('&lt;i class="glyphicon glyphicon-repeat">&lt;/i>', ['grid-demo'], ['data-pjax'=>0, 'class' => 'btn btn-default', 'title'=>Yii::t('kvgrid', 'Reset Grid')])
            ],
            '{export}',
            '{toggleData}'
        ],
        'pjax' => true,
        'bordered' => true,
        'striped' => false,
        'condensed' => false,
        'responsive' => true,
        'hover' => true,
        'floatHeader' => true,
        'floatHeaderOptions' => ['scrollingTop' => $scrollingTop],
        'showPageSummary' => true,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY
        ],
    ]);
    
    ?>


    <?= 
    $this->registerJs(
        "$(document).on('ready pjax:success', function() {  // 'pjax:success' use if you have used pjax
    $('.view').click(function(e){
       e.preventDefault();
       $('#pModal').modal('show')
                  .find('.modal-content')
                  .load($(this).attr('href'));
   });
});
");

    yii\bootstrap\Modal::begin([
        'header'=>'<h4>卡注入用户</h4>',
        'id'=>'pModal',
//        'size'=>'modal-lg',
    ]);
    yii\bootstrap\Modal::end();

    ?>
</div>
