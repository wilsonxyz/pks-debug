<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "item_sparepart".
 *
 * @property int $id
 * @property string $name
 * @property string|null $remark
 * @property int $listed
 * @property int $qty
 *
 * @property PurchaseOrderDetail[] $purchaseOrderDetails 
 */
class ItemSparepart extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item_sparepart';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['remark'], 'string'],
            [['listed', 'qty'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'remark' => 'Remark',
            'listed' => 'Listed',
            'qty' => 'Qty'
        ];
    }

    
    /** 
        * Gets query for [[PurchaseOrderDetails]]. 
        * 
        * @return \yii\db\ActiveQuery 
        */ 
    public function getPurchaseOrderDetails() 
    { 
        return $this->hasMany(PurchaseOrderDetail::class, ['item_id' => 'id']); 
    } 

}
