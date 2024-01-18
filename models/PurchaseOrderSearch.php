<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PurchaseOrder;

/**
 * PurchaseOrderSearch represents the model behind the search form of `app\models\PurchaseOrder`.
 */
class PurchaseOrderSearch extends PurchaseOrder
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'purchase_date', 'remark_1', 'remark_2', 'printed_time', 'created_time', 'updated_time'], 'safe'],
            [['supplier_id', 'division_id', 'warehouse_id', 'ppn_id', 'pay_with_giro', 'paid', 'ssp', 'transfer', 'printed_count', 'printed_by', 'created_by', 'updated_by'], 'integer'],
            [['total', 'total_ppn', 'total_dpp'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PurchaseOrder::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'purchase_date' => $this->purchase_date,
            'supplier_id' => $this->supplier_id,
            'division_id' => $this->division_id,
            'warehouse_id' => $this->warehouse_id,
            'ppn_id' => $this->ppn_id,
            'total' => $this->total,
            'total_ppn' => $this->total_ppn,
            'total_dpp' => $this->total_dpp,
            'pay_with_giro' => $this->pay_with_giro,
            'paid' => $this->paid,
            'ssp' => $this->ssp,
            'transfer' => $this->transfer,
            'printed_count' => $this->printed_count,
            'printed_by' => $this->printed_by,
            'printed_time' => $this->printed_time,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'remark_1', $this->remark_1])
            ->andFilterWhere(['like', 'remark_2', $this->remark_2]);

        return $dataProvider;
    }
}
