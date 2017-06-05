<?php

namespace app\admin\controllers;

use app\models\Feature;
use app\models\Model;
use app\models\Variant;
use dench\image\models\Image;
use dench\sortable\actions\SortingAction;
use Exception;
use Yii;
use app\models\Product;
use app\admin\models\ProductSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class Product2Controller extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'sorting' => [
                'class' => SortingAction::className(),
                'query' => Product::find(),
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch(['all' => Yii::$app->request->get('all')]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();

        $model->loadDefaultValues();

        $modelsVariant = [new Variant()];

        $modelsVariant[0]->loadDefaultValues();

        if ($model->load(Yii::$app->request->post())) {

            $modelsVariant = Model::createMultiple(Variant::classname());
            Model::loadMultiple($modelsVariant, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsVariant),
                    ActiveForm::validate($model)
                );
            }

            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsVariant) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (!empty($deletedIDs)) {
                            Variant::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsVariant as $modelVariant) {
                            /** @var Variant $modelVariant */
                            $modelVariant->product_id = $model->id;
                            if (!($flag = $modelVariant->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', Yii::t('app', 'Information has been saved successfully'));
                        return $this->redirect(['index']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelsVariant' => $modelsVariant,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        /** @var $model Product */
        $model = $this->findModelMulti($id);

        /** @var $modelsVariant Variant[] */
        $modelsVariant = Variant::find()->where(['product_id' => $id])->multilingual()->all();

        $variantImages = [];
        foreach ($modelsVariant as $modelVariant) {
            $variantImages[] = $modelVariant->images;
        }

        $features = Feature::getObjectList(true, $model->category_ids);

        if ($post = Yii::$app->request->post()) {
            $model->load($post);

            $oldIDs = ArrayHelper::map($modelsVariant, 'id', 'id');
            $modelsVariant = Model::createMultiple(Variant::classname(), $modelsVariant);
            foreach ($modelsVariant as $modelVariant) {
                $modelVariant->image_ids = [];
            }
            Model::loadMultiple($modelsVariant, Yii::$app->request->post());
            $variantImages = [];
            foreach ($modelsVariant as $modelVariant) {
                Yii::error($modelVariant);
                if (isset($modelVariant->enabled)) {
                    $variantImages[] = $modelVariant->images;
                }
            }
            if (!Yii::$app->request->isPjax) {

                $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsVariant, 'id', 'id')));

                // ajax validation
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ArrayHelper::merge(
                        ActiveForm::validateMultiple($modelsVariant),
                        ActiveForm::validate($model)
                    );
                }

                /** @var Image[] $images */
                $images = [];
                $image_ids = isset($post['Image']) ? $post['Image'] : [];
                foreach ($image_ids as $key => $image) {
                    $images[$key] = Image::findOne($key);
                }
                if ($images) {
                    Model::loadMultiple($images, $post);
                }

                $valid = $model->validate();
                $valid = Model::validateMultiple($modelsVariant) && $valid;
                $valid = Model::validateMultiple($images) && $valid;

                if ($valid) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = $model->save(false)) {
                            if (!empty($deletedIDs)) {
                                Variant::deleteAll(['id' => $deletedIDs]);
                            }
                            foreach ($modelsVariant as $modelVariant) {
                                /** @var Variant $modelVariant */
                                $modelVariant->product_id = $model->id;
                                if (!($flag = $modelVariant->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                            foreach ($images as $key => $image) {
                                //Yii::error([print_r($image->id,1)]);
                                if (!($flag = $image->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }
                        if ($flag) {
                            $transaction->commit();
                            Yii::$app->session->setFlash('success',
                                Yii::t('app', 'Information has been saved successfully'));
                            return $this->redirect(['index']);
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelsVariant' => (empty($modelsVariant)) ? [new Variant()] : $modelsVariant,
            'variantImages' => $variantImages,
            'features' => $features,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product|\yii\db\ActiveRecord
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelMulti($id)
    {
        if (($model = Product::find()->where(['id' => $id])->multilingual()->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
