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
 * This is the model class for table "complect".
 *
 * @property integer $id
 * @property integer $position
 *
 * @property string $name
 *
 * @property Product[] $products
 */
class Complect extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'complect';
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
                    'product_ids' => ['products'],
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
            [['name'], 'string', 'max' => 255],
            [['name'], 'required'],
            [['position'], 'integer'],
            [['product_ids'], 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'position' => Yii::t('app', 'Position'),
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
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->viaTable('product_complect', ['complect_id' => 'id']);
    }

    /**
     * @return array
     */
    public static function getList()
    {
        return ArrayHelper::map(self::find()->orderBy('position')->all(), 'id', 'name');
    }
}
