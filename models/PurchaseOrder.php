<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "purchase_order".
 *
 * @property string $id
 * @property string $purchase_date
 * @property float $total
 * @property float $total_ppn
 * @property float $total_dpp
 * @property int $pay_with_giro
 * @property int $paid
 * @property int $ssp
 * @property int $transfer
 * @property string|null $remark_1
 * @property string|null $remark_2
 *
 * @property PurchaseOrderDetail[] $purchaseOrderDetails
 */
class PurchaseOrder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'purchase_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'purchase_date', 'total', 'total_ppn', 'total_dpp'], 'required'],
            [['purchase_date', 'printed_time', 'created_time', 'updated_time'], 'safe'],
            [['pay_with_giro', 'paid', 'ssp', 'transfer', 'printed_count'], 'integer'],
            [['total', 'total_ppn', 'total_dpp'], 'number'],
            [['remark_1', 'remark_2'], 'string'],
            [['id'], 'string', 'max' => 15],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'purchase_date' => 'Tgl. Pembelian',
            'total' => 'Total',
            'total_ppn' => 'Total Ppn',
            'total_dpp' => 'Total Dpp',
            'pay_with_giro' => 'Pay Later',
            'paid' => 'Lunas',
            'ssp' => 'Ssp',
            'transfer' => 'Transfer',
            'remark_1' => 'Remark 1',
            'remark_2' => 'Remark 2',
            'printed_count' => 'Printed Count',
        ];
    }

    /**
     * Gets query for [[PurchaseOrderDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseOrderDetails()
    {
        return $this->hasMany(PurchaseOrderDetail::class, ['purchase_order_id' => 'id']);
    }

}
