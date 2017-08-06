<?php

namespace app\models;

use dench\image\models\Image;
use dench\language\behaviors\LanguageBehavior;
use dench\sortable\behaviors\SortableBehavior;
use omgdef\multilingual\MultilingualQuery;
use voskobovich\linker\LinkerBehavior;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $slug
 * @property integer $brand_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $position
 * @property boolean $enabled
 * @property boolean $price_from
 * @property string $view
 *
 * @property string $name
 * @property string $h1
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $text
 *
 * @property array $category_ids
 * @property array $option_ids
 * @property array $complect_ids
 * @property array $status_ids
 *
 * @property Brand $brand
 * @property Category[] $categories
 * @property Variant[] $variants
 * @property Product[] $options
 * @property Status[] $statuses
 * @property Complect[] $complects
 * @property Image $image
 */
class Product extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            LanguageBehavior::className(),
            TimestampBehavior::className(),
            SortableBehavior::className(),
            'slug' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'ensureUnique' => true
            ],
            [
                'class' => LinkerBehavior::className(),
                'relations' => [
                    'category_ids' => ['categories'],
                    'option_ids' => ['options'],
                    'complect_ids' => ['complects'],
                    'status_ids' => ['statuses'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'h1', 'title', 'category_ids'], 'required'],
            [['brand_id', 'position'], 'integer'],
            [['slug', 'name', 'h1', 'title', 'keywords', 'view'], 'string', 'max' => 255],
            [['description', 'text'], 'string'],
            [['slug', 'name', 'h1', 'title', 'keywords', 'description', 'text'], 'trim'],
            [['enabled', 'price_from'], 'boolean'],
            [['enabled'], 'default', 'value' => true],
            [['category_ids', 'option_ids', 'complect_ids', 'status_ids'], 'each', 'rule' => ['integer']],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::className(), 'targetAttribute' => ['brand_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => Yii::t('app', 'Slug'),
            'brand_id' => Yii::t('app', 'Brand'),
            'created_at' => Yii::t('app', 'Created'),
            'updated_at' => Yii::t('app', 'Updated'),
            'position' => Yii::t('app', 'Position'),
            'enabled' => Yii::t('app', 'Enabled'),
            'name' => Yii::t('app', 'Name'),
            'h1' => Yii::t('app', 'H1'),
            'title' => Yii::t('app', 'Title'),
            'keywords' => Yii::t('app', 'Keywords'),
            'description' => Yii::t('app', 'Description'),
            'text' => Yii::t('app', 'Text'),
            'price_from' => Yii::t('app', 'from'),
            'view' => Yii::t('app', 'View template'),
            'category_ids' => Yii::t('app', 'Categories'),
            'status_ids' => Yii::t('app', 'Statuses'),
            'complect_ids' => Yii::t('app', 'Complectation'),
            'option_ids' => Yii::t('app', 'Additional options'),
        ];
    }

    public static function viewPage($id)
    {
        if (is_numeric($id)) {
            $page = self::findOne($id);
        } else {
            $page = self::findOne(['slug' => $id]);
        }
        if ($page === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        Yii::$app->view->params['page'] = $page;
        Yii::$app->view->title = $page->title;
        if ($page->description) {
            Yii::$app->view->registerMetaTag([
                'name' => 'description',
                'content' => $page->description
            ]);
        }
        if ($page->keywords) {
            Yii::$app->view->registerMetaTag([
                'name' => 'keywords',
                'content' => $page->keywords
            ]);
        }
        return $page;
    }

    /**
     * @return MultilingualQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])->viaTable('product_category', ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOptions()
    {
        return $this->hasMany(Product::className(), ['id' => 'option_id'])->viaTable('product_option', ['product_id' => 'id']);
    }

    /**
     * @param boolean $enabled
     * @return \yii\db\ActiveQuery
     */
    public function getVariants()
    {
        return $this->hasMany(Variant::className(), ['product_id' => 'id'])->orderBy(['position' => SORT_ASC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComplects()
    {
        return $this->hasMany(Complect::className(), ['id' => 'complect_id'])->viaTable('product_complect', ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatuses()
    {
        return $this->hasMany(Status::className(), ['id' => 'status_id'])->viaTable('product_status', ['product_id' => 'id']);
    }

    /**
     * @return Image
     */
    public function getImage()
    {
        if ($variant = current($this->variants)) {
            return $variant->image;
        }

        return null;
    }

    /**
     * @param boolean|null $enabled
     * @return array
     */
    public static function getList($enabled)
    {
        return ArrayHelper::map(self::find()->andFilterWhere(['enabled' => $enabled])->orderBy('position')->all(), 'id', 'name');
    }
}
