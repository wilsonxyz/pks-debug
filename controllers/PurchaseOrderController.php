<?php

namespace app\controllers;

use Yii;
use app\models\Model;
use app\models\PurchaseOrder;
use app\models\PurchaseOrderDetail;
use app\models\PurchaseOrderSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\filters\VerbFilter;

/**
 * PurchaseOrderController implements the CRUD actions for PurchaseOrder model.
 */
class PurchaseOrderController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all PurchaseOrder models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PurchaseOrderSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PurchaseOrder model.
     * @param string $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PurchaseOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $details = [ new PurchaseOrderDetail ];
        $model = new PurchaseOrder();
        $model->id = 'BSP-240118001';
        $model->purchase_date = date('Y-m-d');
        $model->transfer = 1;
        $model->pay_with_giro = 0;
        $model->total = 0;
        $model->total_dpp = 0;
        $model->total_ppn = 0;

    /*
        $seq = Sequence::FindOne(['id' => 'BSP', 'name' => (int)date('ymd')]);
        if(is_null($seq))
        {
            $_seq = new Sequence();
            $_seq->id = 'BSP';
            $_seq->name = (int)date('ymd');
            $_seq->value = 0;
            $_seq->save();
            $model->id = $_seq->id . '/' . $_seq->name . str_pad($_seq->value+1, 3, "0", STR_PAD_LEFT);
        }
        else {
            $seq->value += 1;
            $model->id = $seq->id . '/' . $seq->name . str_pad($seq->value, 3, "0", STR_PAD_LEFT);
            $seq->update();
        }
        */

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $details = Model::createMultiple(PurchaseOrderDetail::class);
                Model::loadMultiple($details, Yii::$app->request->post());

                // assign purchase_order_id
                foreach ($details as $detail) {
                    $detail->purchase_order_id = $model->id;
                }

                // ajax validation
			    if(Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ArrayHelper::merge(
                        ActiveForm::validateMultiple($details),
                        ActiveForm::validate($model)
                    );
			    }

                $model->created_by = Yii::$app->user->id;
                $model->created_time = date('Y-m-d H:i:s');
                
                // validate all models
                $valid1 = $model->validate();
                $valid2 = Model::validateMultiple($details);
                $valid = $valid1 && $valid2;

                if($valid) {
                    $trx = Yii::$app->db->beginTransaction();
                    // save master record
                    if($flag = $model->save()){
                        // save purchase order details
                        foreach ($details as $detail) {
                            if(!($flag = $detail->save())) {
                                break;
                            }
                            else {
                            /*
                                $stock = Stock::findOne(['item_id' => $detail->item_id, 'warehouse_id' => $model->warehouse_id]);
                                if(is_null($stock)) {
                                    $new_stock = new Stock();
                                    $new_stock->warehouse_id = $model->warehouse_id;
                                    $new_stock->item_id = $detail->item_id;
                                    $new_stock->qty = $detail->qty;
                                    if (!($flag = $new_stock->save())) {
                                        break;
                                    }
                                }
                                else {
                                    // already in stock, just update the stock
                                    $stock->qty += $detail->qty;
                                    $flag = $stock->update();
                                    if ($flag) {
                                        // insert into inventory_log
                                        $inv_log = new InventoryLog();
                                        
                                    }
                                }
                                */
                            }
                        }
                        
                        if ($flag) {
                            $trx->commit();
                            return $this->redirect(['view', 'id' => $model->id]);
                        }
                    }
                    else {
                        $trx->rollBack();
                        throw new \Exception ( implode ( "<br />" , \yii\helpers\ArrayHelper::getColumn ( $model->errors , 0 , false ) ) );
                    }
                }
                else {
                    if(!$valid1) {
                        throw new \Exception ( implode ( "<br />" , \yii\helpers\ArrayHelper::getColumn ( $model->errors , 0 , false ) ) );
                    }
                    if(!$valid2) {
                        throw new \Exception ('Error validated $details, please contact your administrator');
                    }
                }

                
                
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'details' => $details
        ]);
    }

    /**
     * Updates an existing PurchaseOrder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PurchaseOrder model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PurchaseOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return PurchaseOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PurchaseOrder::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
