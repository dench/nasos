<?php

namespace app\admin\controllers;

use app\models\Feature;
use dench\image\models\Image;
use Yii;
use app\models\Variant;
use app\admin\models\VariantSearch;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VariantController implements the CRUD actions for Variant model.
 */
class VariantController extends Controller
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

    /**
     * Lists all Variant models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VariantSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Variant model.
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
     * Creates a new Variant model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Variant();

        $model->loadDefaultValues();

        $model->product_id = Yii::$app->request->get('product_id');

        $features = !empty($model->product->category_ids) ? Feature::getObjectList(true, $model->product->category_ids) : [];

        $images = [];

        if ($post = Yii::$app->request->post()) {
            /** @var Image[] $images */
            $images = [];
            $image_ids = isset($post['Image']) ? $post['Image'] : [];
            foreach ($image_ids as $key => $image) {
                $images[$key] = Image::findOne($key);
            }
            if ($images) {
                Model::loadMultiple($images, $post);
            } else {
                $model->image_ids = [];
            }

            $model->load($post);

            $error = [];
            if (!$model->validate()) $error['model'] = $model->errors;
            foreach ($images as $key => $image) {
                if (!$image->validate()) $error['image'][$key] = $image->errors;
            }
            if (empty($error)) {
                $model->save(false);
                foreach ($images as $key => $image) {
                    $image->save(false);
                }
                Yii::$app->session->setFlash('success', Yii::t('app', 'Information added successfully'));
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'features' => $features,
            'images' => $images,
        ]);
    }

    /**
     * Updates an existing Variant model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModelMulti($id);

        $features = Feature::getObjectList(true, $model->product->category_ids);

        $images = $model->images;

        if ($post = Yii::$app->request->post()) {
            $model->load($post);
            /** @var Image[] $images */
            $images = [];
            $image_ids = isset($post['Image']) ? $post['Image'] : [];
            foreach ($image_ids as $key => $image) {
                $images[$key] = Image::findOne($key);
            }
            if ($images) {
                Model::loadMultiple($images, $post);
            } else {
                $model->image_ids = [];
            }

            $error = [];
            if (!$model->validate()) $error['model'] = $model->errors;
            foreach ($images as $key => $image) {
                if (!$image->validate()) $error['image'][$key] = $image->errors;
            }
            if (empty($error)) {
                $model->save(false);
                foreach ($images as $key => $image) {
                    $image->save(false);
                }
                Yii::$app->session->setFlash('success', Yii::t('app', 'Information has been saved successfully'));
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'features' => $features,
            'images' => $images,
        ]);
    }

    /**
     * Deletes an existing Variant model.
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
     * Finds the Variant model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Variant the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Variant::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Variant|\yii\db\ActiveRecord
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelMulti($id)
    {
        if (($model = Variant::find()->where(['id' => $id])->multilingual()->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
