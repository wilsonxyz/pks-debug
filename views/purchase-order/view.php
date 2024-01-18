<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\PurchaseOrder $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Purchase Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="purchase-order-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'purchase_date',
            'supplier_id',
            'division_id',
            'warehouse_id',
            'ppn_id',
            'total',
            'total_ppn',
            'total_dpp',
            'pay_with_giro',
            'paid',
            'ssp',
            'transfer',
            'remark_1:ntext',
            'remark_2:ntext',
            'printed_count',
            'printed_by',
            'printed_time',
            'created_by',
            'created_time',
            'updated_by',
            'updated_time',
        ],
    ]) ?>

</div>
