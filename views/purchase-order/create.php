<!-- on your view layout file HEAD section -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PurchaseOrder $model */

$this->title = 'Create Purchase Order';
$this->params['breadcrumbs'][] = ['label' => 'Purchase Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-order-create">

    <?= $this->render('_tform', [
        'model' => $model,
        'details' => $details
    ]) ?>

</div>
