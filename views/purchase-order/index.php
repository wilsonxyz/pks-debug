<?php

use yii\helpers\Html;
use kartik\grid\GridView;

include '../config/export.php';

/** @var yii\web\View $this */
/** @var app\models\PurchaseOrderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Purchase Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-order-index">

    <p>
        <?= Html::a('Create Purchase Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php 
        $gridColumns = [
            [
                'class' => 'kartik\grid\ActionColumn',
                'dropdown' => true,
                'vAlign'=>'middle',
            ],
            'id',
            'purchase_date',
            [
                'attribute' => 'total', 
                'format' => ['decimal', 2],
                'hAlign' => 'right',
                'pageSummary' => true,
                'pageSummaryFunc' => GridView::F_SUM
            ],
            [
                'attribute' => 'total_dpp', 
                'format' => ['decimal', 2],
                'hAlign' => 'right',
                'pageSummary' => true,
                'pageSummaryFunc' => GridView::F_SUM
            ],
            [
                'attribute' => 'total_ppn', 
                'format' => ['decimal', 2],
                'hAlign' => 'right',
                'pageSummary' => true,
                'pageSummaryFunc' => GridView::F_SUM
            ],
            [
                'class' => 'kartik\grid\BooleanColumn',
                'attribute' => 'transfer'
            ],
            [
                'class' => 'kartik\grid\BooleanColumn',
                'attribute' => 'pay_with_giro',
            ],
            [
                'class' => 'kartik\grid\BooleanColumn',
                'attribute' => 'paid'
            ],
        ];
    ?>
    <?= GridView::widget([
        'id' => 'kv-grid-purchase-order',
        'dataProvider'=>$dataProvider,
        'filterModel'=>$searchModel,
        'columns'=>$gridColumns,
        'containerOptions'=>['style'=>'overflow: auto'],
        'headerRowOptions'=>['class'=>'kartik-sheet-style'],
        'filterRowOptions'=>['class'=>'kartik-sheet-style'],
        'pjax'=>true, // pjax is set to always true for this demo
        'export'=>[
            'fontAwesome'=>true
        ],
        // parameters from the demo form
        'bordered'=>true,
        'striped'=>false,
        'condensed'=>true,
        'responsive'=>false,
        'hover'=>true,
        'showPageSummary'=>true,
        'panel'=>[
            'type'=>GridView::TYPE_PRIMARY,
        ],
        'persistResize'=>false,
        'exportConfig'=>$defaultExportConfig,
    ]); ?>


</div>
