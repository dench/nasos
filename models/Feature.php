<?php

namespace app\models;

use dench\language\behaviors\LanguageBehavior;
use dench\sortable\behaviors\SortableBehavior;
use omgdef\multilingual\MultilingualQuery;
use voskobovich\linker\LinkerBehavior;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "feature".
 *
 * @property integer $id
 * @property integer $name
 * @property integer $after
 * @property integer $position
 * @property boolean $filter
 * @property boolean $enabled
 *
 * @property Category[] $categories
 * @property Value[] $values
 * @property Variant[] $variants
 */
class Feature extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feature';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            LanguageBehavior::className(),
            SortableBehavior::className(),
            [
                'class' => LinkerBehavior::className(),
                'relations' => [
                    'variant_ids' => ['variants'],
                    'category_ids' => ['categories'],
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
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['after'], 'string', 'max' => 32],
            [['position'], 'integer'],
            [['enabled', 'filter'], 'boolean'],
            [['enabled'], 'default', 'value' => true],
            [['filter'], 'default', 'value' => false],
            [['variant_ids', 'category_ids'], 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('app', 'Name'),
            'after' => Yii::t('app', 'After'),
            'position' => Yii::t('app', 'Position'),
            'filter' => Yii::t('app', 'Filter'),
            'enabled' => Yii::t('app', 'Enabled'),
        ];
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
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])->viaTable('feature_category', ['feature_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValues()
    {
        return $this->hasMany(Value::className(), ['feature_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariants()
    {
        // TODO: value_id != feature_id
        return $this->hasMany(Variant::className(), ['id' => 'variant_id'])->viaTable('variant_value', ['value_id' => 'id']);
    }

    /**
     * @param boolean|null $enabled
     * @param array $category_ids
     * @return array
     */
    public static function getList($enabled, $category_ids)
    {
        return ArrayHelper::map(self::find()->joinWith(['categories'])->andFilterWhere(['feature.enabled' => $enabled])->andFilterWhere(['category_id' => $category_ids])->orderBy('position')->all(), 'id', 'name');
    }

    /**
     * @param boolean|null $enabled
     * @param array $category_ids
     * @return @return MultilingualQuery|\yii\db\ActiveQuery
     */
    public static function getObjectList($enabled, array $category_ids)
    {
        return self::find()->joinWith(['categories'])->andFilterWhere(['feature.enabled' => $enabled])->andFilterWhere(['category_id' => $category_ids])->orderBy('position')->all();
    }

    /**
     * @param boolean|null $enabled
     * @param array $category_ids
     * @return @return MultilingualQuery|\yii\db\ActiveQuery
     */
    public static function getFilterList($enabled, array $category_ids)
    {
        return self::find()->where(['filter' => true])->joinWith(['categories'])->andFilterWhere(['feature.enabled' => $enabled])->andFilterWhere(['category_id' => $category_ids])->orderBy('position')->all();
    }
}
