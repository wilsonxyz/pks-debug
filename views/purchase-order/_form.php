<?php

use kartik\checkbox\CheckboxX;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\MaskedInput;
use yii\widgets\ActiveForm;


/** @var yii\web\View $this */
/** @var app\models\PurchaseOrder $model */
/** @var yii\widgets\ActiveForm $form */

$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .card-item-title").each(function(index) {
        jQuery(this).html("Item : " + (index + 1))
    });
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .card-item-title").each(function(index) {
        jQuery(this).html("Item : " + (index + 1))
    });
});
';

$this->registerJs($js);

?>

<div class="purchase-order-form">

    <?php $form = ActiveForm::begin(['id' => 'form-purchase-order']); ?>
    <div class="row">
        <div class="col-3">
            <?= $form->field($model, 'id')->textInput(['maxlength' => true, 'readonly' => true]) ?>
        </div>
        <div class="col-3">
            <?= $form->field($model, 'purchase_date')->widget(DatePicker::class,
                [
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]) ?>
        </div>
        <div class="col-3">
            <p style="height: min-content; color: red;">*</p>
            <?= $form->field($model, 'transfer')->widget(CheckboxX::class, [
                'pluginOptions'=> ['threeState' => false],
                'autoLabel' => false,
                'labelSettings' => [
                    'label' => 'Transfer',
                    'position' => CheckboxX::LABEL_RIGHT
                ]
            ])->label(false) ?>
        </div>
        
        <div class="col-3">
            <p style="height: min-content; color: red;">*</p>
            <?= $form->field($model, 'pay_with_giro')->widget(CheckboxX::class, [
                'pluginOptions'=> ['threeState' => false],
                'autoLabel' => false,
                'labelSettings' => [
                    'label' => 'Pay Later',
                    'position' => CheckboxX::LABEL_RIGHT
                ]
            ])->label(false) ?>
        </div>
        
        <div class="col-6">
            <?= $form->field($model, 'remark_1')->textarea(['rows' => 3]) ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'remark_2')->textarea(['rows' => 3]) ?>
        </div>
    </div>
    
    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',  // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items',          // required: css class selector
        'widgetItem' => '.item',                     // required: css class
        'limit' => 12 ,                              // the maximum times, an element can be cloned (default 999)
        'min' => 1,                                  // 0 or 1 (default 1)
        'insertButton' => '.add-item',               // css class
        'deleteButton' => '.remove-item',            // css class
        'model' => $details[0],
        'formId' => 'form-purchase-order',
        'formFields' => [
            'id',
            'item_id',
            'brand',
            'serial_no',
            'qty',
            'price',
            'disc_percent',
            'disc_rp',
            'ppn',
            'dpp',
            'total' 
        ],
    ]); ?>
    <div class="card">
        <div class="card-header">
            <span><i class="fa fa-cart-plus"></i></span> 
            <span style="font-size: large;">&nbsp; Items Sparepart</span>
            <button type="button" class="float-right add-item btn btn-success btn-sm">
                <i class="fa fa-plus"></i> Add item</button>
        </div>
        <div class="card-body container-items">
            <?php foreach ($details as $i => $detail): ?>
            <?php
                // necessary for update action.
                if (! $detail->isNewRecord) {
                    echo Html::activeHiddenInput($detail, "[{$i}]id");
                }
            ?>
            <!-- sub card -->
            <div class="card item">
                <div class="card-header">
                    <span class="card-item-title" style="color: blue;">Item : <?= ($i+1) ?></span> 
                    <button type="button" class="float-right remove-item btn btn-danger btn-sm">
                        <i class="fa fa-minus"></i></button>
                </div>
                <div class="card-body">
                    <table style="width: fit-content">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <?= $form->field($detail, "[{$i}]item_id")->widget(Select2::class, [
                                                'data' => ArrayHelper::map(\app\models\ItemSparepart::find()->where(['listed' => 1])->all(), 'id', 'name'),
                                                'language' => 'en',
                                                'options' => ['placeholder' => 'Select item ...'],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                ],
                                            ]);
                                    ?>
                                </td>
                                <td>
                                    <?= $form->field($detail, "[{$i}]brand")->textInput(); ?>
                                </td>
                                <td>
                                    <?= $form->field($detail, "[{$i}]serial_no")->textInput(); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?= $form->field($detail, "[{$i}]qty")->widget(MaskedInput::class,
                                        [
                                            'clientOptions' => [
                                                'alias' => 'decimal',
                                                'groupSeparator' => ',',
                                                'digits' => 2,
                                                'autoGroup' => true,
                                                'removeMaskOnSubmit' => true,
                                                'rightAlign' => false,
                                            ],
                                            'options' => [
                                                'class' => 'form-control',
                                                'onchange' => 'calculateSubtotal($(this))',
                                            ]
                                        ]) ?>
                                </td>
                                <td>
                                    <?= $form->field($detail, "[{$i}]price")->widget(MaskedInput::class,
                                        [
                                            'clientOptions' => [
                                                'alias' => 'numeric',
                                                'groupSeparator' => ',',
                                                'digits' => 2,
                                                'autoGroup' => true,
                                                'removeMaskOnSubmit' => true,
                                                'rightAlign' => false,
                                            ],
                                            'options' => [
                                                'class' => 'form-control',
                                                'onchange' => 'calculateSubtotal($(this))',
                                            ]
                                        ]) ?>
                                </td>
                                <td>
                                    <?= $form->field($detail, "[{$i}]disc_percent")->widget(MaskedInput::class,
                                        [
                                            'clientOptions' => [
                                                'alias' => 'numeric',
                                                'groupSeparator' => ',',
                                                'digits' => 2,
                                                'autoGroup' => true,
                                                'removeMaskOnSubmit' => true,
                                                'rightAlign' => false,
                                            ],
                                            'options' => [
                                                'class' => 'form-control',
                                                'onchange' => 'calculateSubtotal($(this))',
                                            ]
                                        ]) ?>
                                </td>
                                <td>
                                    <?= $form->field($detail, "[{$i}]disc_rp")->widget(MaskedInput::class,
                                        [
                                            'clientOptions' => [
                                                'alias' => 'numeric',
                                                'groupSeparator' => ',',
                                                'digits' => 0,
                                                'autoGroup' => true,
                                                'removeMaskOnSubmit' => true,
                                                'rightAlign' => false,
                                            ],
                                            'options' => [
                                                'class' => 'form-control',
                                                'onchange' => 'calculateSubtotal($(this))',
                                            ]
                                        ]) ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?= $form->field($detail, "[{$i}]ppn")->widget(MaskedInput::class,
                                        [
                                            'clientOptions' => [
                                                'alias' => 'numeric',
                                                'groupSeparator' => ',',
                                                'digits' => 2,
                                                'autoGroup' => true,
                                                'removeMaskOnSubmit' => true,
                                                'rightAlign' => false,
                                            ],
                                            'options' => [
                                                'class' => 'form-control',
                                                'readonly' => true
                                            ]
                                        ]) ?>
                                </td>
                                <td>
                                    <?= $form->field($detail, "[{$i}]dpp")->widget(MaskedInput::class,
                                        [
                                            'clientOptions' => [
                                                'alias' => 'numeric',
                                                'groupSeparator' => ',',
                                                'digits' => 0,
                                                'autoGroup' => true,
                                                'removeMaskOnSubmit' => true,
                                                'rightAlign' => false,
                                            ],
                                            'options' => [
                                                'class' => 'form-control',
                                                'readonly' => true
                                            ]
                                        ]) ?>
                                </td>
                                <td colspan="2">
                                    <?= $form->field($detail, "[{$i}]total")->widget(MaskedInput::class,
                                        [
                                            'clientOptions' => [
                                                'alias' => 'numeric',
                                                'groupSeparator' => ',',
                                                'digits' => 0,
                                                'autoGroup' => true,
                                                'removeMaskOnSubmit' => true,
                                                'rightAlign' => false,
                                            ],
                                            'options' => [
                                                'class' => 'form-control',
                                                'readonly' => true
                                            ]
                                        ]) ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div> <!-- card-body -->
            </div> <!-- card item -->
            <?php endforeach; ?>
        </div> <!-- card-body -->
    </div> <!-- card -->
    <?php DynamicFormWidget::end(); ?>
    

    <?= $form->field($model, 'total')->widget(\yii\widgets\MaskedInput::class,
            [
                'clientOptions' => [
                    'alias' => 'numeric',
                    'groupSeparator' => ',',
                    'digits' => 2,
                    'autoGroup' => true,
                    'removeMaskOnSubmit' => true,
                    'rightAlign' => false,
                ]
            ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
$script = <<< JS
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    calculateTotal();   
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    calculateTotal();    
});

function getItemPrice(item){
	var index  = item.attr("id").replace(/[^0-9.]/g, "");
	var item_id = $('#purchaseorderdetail-'+ index + "-item_id").val();
	$.get('../item/get-price', {id : item_id}, function(data){
		$('#purchaseorderdetail-' + index + '-price').val(data);
		$('#purchaseorderdetail-' + index + '-qty').val(1);
		$('#purchaseorderdetail-' + index + '-total').val(data);
		calculateTotal();
	});		
}

function calculateSubtotal(item){    
/*
	var index  = item.attr("id").replace(/[^0-9.]/g, "");	
	var qty = $('#purchaseorderdetail-' + index + '-qty').val();
	qty = qty == "" ? 0 : Number(qty.split(",").join(""));
	var price = $('#purchaseorderdetail-' + index + '-price').val();
	price = price == "" ? 0 : Number(price.split(",").join(""));
	$('#purchaseorderdetail-' + index + '-total').val(qty * price);
    */
	calculateTotal();
}

function calculateTotal(){    
    var total = 0;        
    /*
    jQuery(".dynamicform_wrapper .remove-item").each(function(index) {
        var subtotal = $('#purchaseorderdetail-' + index + '-total').val();
        if(typeof(subtotal) != 'undefined'){
            subtotal = subtotal == "" ? 0 : Number(subtotal.split(",").join(""));    
            total = total + subtotal;    
        }        
    });
    $('#purchaseorder-total').val(total); */
}
JS;
$this->registerJs($script, $this::POS_END);
?>