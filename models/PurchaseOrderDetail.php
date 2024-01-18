<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "purchase_order_detail".
 *
 * @property int|null $id
 * @property string $purchase_order_id
 * @property int $item_id
 * @property float $price
 * @property float $qty
 * @property float $disc_percent
 * @property float $disc_rp
 * @property float $ppn
 * @property float $dpp
 * @property float $total
 * @property string|null $serial_no
 * @property string|null $brand
 *
 * @property ItemSparepart $item
 * @property PurchaseOrder $purchaseOrder
 */
class PurchaseOrderDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'purchase_order_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'item_id'], 'integer'],
            [['purchase_order_id', 'item_id', 'price', 'qty', 'disc_percent', 'disc_rp', 'ppn', 'dpp', 'total'], 'required'],
            [['price', 'qty', 'disc_percent', 'disc_rp', 'ppn', 'dpp', 'total'], 'number'],
            [['purchase_order_id'], 'string', 'max' => 15],
            [['serial_no', 'brand'], 'string', 'max' => 255],
            [['purchase_order_id'], 'exist', 'skipOnError' => true, 'targetClass' => PurchaseOrder::class, 'targetAttribute' => ['purchase_order_id' => 'id']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => ItemSparepart::class, 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'purchase_order_id' => 'Purchase Order ID',
            'item_id' => 'Item ID',
            'price' => 'Price',
            'qty' => 'Qty',
            'disc_percent' => 'Disc Percent',
            'disc_rp' => 'Disc Rp',
            'ppn' => 'Ppn',
            'dpp' => 'Dpp',
            'total' => 'Total',
            'serial_no' => 'Serial No',
            'brand' => 'Merk'
        ];
    }

    /**
     * Gets query for [[Item]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(ItemSparepart::class, ['id' => 'item_id']);
    }

    /**
     * Gets query for [[PurchaseOrder]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseOrder()
    {
        return $this->hasOne(PurchaseOrder::class, ['id' => 'purchase_order_id']);
    }
}
