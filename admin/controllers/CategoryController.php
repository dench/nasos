<?php

namespace app\admin\controllers;

use dench\image\models\Image;
use dench\language\models\Language;
use dench\sortable\actions\SortingAction;
use Yii;
use app\models\Category;
use app\admin\models\CategorySearch;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
                'query' => Category::find(),
            ],
        ];
    }

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch(['all' => Yii::$app->request->get('all')]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();

        $model->loadDefaultValues();

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
                foreach (Language::find()->select('id')->column() as $lang) {
                    Yii::$app->cache->delete('_categories-' . $lang);
                }
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'images' => $images,
        ]);
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModelMulti($id);

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
                foreach (Language::find()->select('id')->column() as $lang) {
                    Yii::$app->cache->delete('_categories-' . $lang);
                }
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'images' => $images,
        ]);
    }

    /**
     * Deletes an existing Category model.
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
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category|\yii\db\ActiveRecord
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelMulti($id)
    {
        if (($model = Category::find()->where(['id' => $id])->multilingual()->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
