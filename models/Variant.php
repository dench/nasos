<?php

namespace app\models;

use dench\image\models\Image;
use dench\language\behaviors\LanguageBehavior;
use dench\sortable\behaviors\SortableBehavior;
use omgdef\multilingual\MultilingualQuery;
use voskobovich\linker\LinkerBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "variant".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $code
 * @property integer $price
 * @property integer $price_old
 * @property integer $currency_id
 * @property integer $unit_id
 * @property integer $available
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $position
 * @property boolean $enabled
 *
 * @property string $name
 *
 * @property Currency $currency
 * @property Product $product
 * @property Unit $unit
 * @property Value[] $values
 * @property Image[] $images
 */
class Variant extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'variant';
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
            [
                'class' => LinkerBehavior::className(),
                'relations' => [
                    'value_ids' => ['values'],
                    'image_ids' => [
                        'images',
                        'updater' => [
                            'viaTableAttributesValue' => [
                                'position' => function($updater, $relatedPk, $rowCondition) {
                                    $primaryModel = $updater->getBehavior()->owner;
                                    $image_ids = array_values($primaryModel->image_ids);
                                    return array_search($relatedPk, $image_ids);
                                },
                            ],
                        ],
                    ],
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
            [['product_id', 'currency_id', 'unit_id'], 'required'],
            [['product_id', 'price', 'price_old', 'currency_id', 'unit_id', 'available', 'position'], 'integer'],
            [['code', 'name'], 'string', 'max' => 255],
            [['enabled'], 'boolean'],
            [['enabled'], 'default', 'value' => true],
            [['value_ids', 'image_ids'], 'each', 'rule' => ['integer']],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currency_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Unit::className(), 'targetAttribute' => ['unit_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => Yii::t('app', 'Product'),
            'code' => Yii::t('app', 'Vendor code'),
            'name' => Yii::t('app', 'Name'),
            'price' => Yii::t('app', 'Price'),
            'price_old' => Yii::t('app', 'Price Old'),
            'currency_id' => Yii::t('app', 'Currency'),
            'unit_id' => Yii::t('app', 'Unit'),
            'available' => Yii::t('app', 'Available'),
            'created_at' => Yii::t('app', 'Created'),
            'updated_at' => Yii::t('app', 'Updated'),
            'position' => Yii::t('app', 'Position'),
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
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['id' => 'unit_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValues()
    {
        return $this->hasMany(Value::className(), ['id' => 'value_id'])->viaTable('variant_value', ['variant_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        $name = $this->tableName();

        return $this->hasMany(Image::className(), ['id' => 'image_id'])
            ->viaTable($name . '_image', [$name . '_id' => 'id'])
            ->leftJoin($name . '_image', 'id=image_id')
            ->where([$name . '_image.' . $name . '_id' => $this->id])
            ->orderBy([$name . '_image.position' => SORT_ASC])
            ->indexBy('id');
    }
}
