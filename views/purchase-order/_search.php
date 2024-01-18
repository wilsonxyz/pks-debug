<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PurchaseOrderSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="purchase-order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'purchase_date') ?>

    <?= $form->field($model, 'supplier_id') ?>

    <?= $form->field($model, 'division_id') ?>

    <?= $form->field($model, 'warehouse_id') ?>

    <?php // echo $form->field($model, 'ppn_id') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'total_ppn') ?>

    <?php // echo $form->field($model, 'total_dpp') ?>

    <?php // echo $form->field($model, 'pay_with_giro') ?>

    <?php // echo $form->field($model, 'paid') ?>

    <?php // echo $form->field($model, 'ssp') ?>

    <?php // echo $form->field($model, 'transfer') ?>

    <?php // echo $form->field($model, 'remark_1') ?>

    <?php // echo $form->field($model, 'remark_2') ?>

    <?php // echo $form->field($model, 'printed_count') ?>

    <?php // echo $form->field($model, 'printed_by') ?>

    <?php // echo $form->field($model, 'printed_time') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_time') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'updated_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
