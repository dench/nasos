<?php

namespace app\models;

use app\behaviors\PositionBehavior;
use dench\language\behaviors\LanguageBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "complect".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $position
 *
 * @property string $name
 *
 * @property Product $product
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
            PositionBehavior::className(),
        ];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
            [['product_id', 'name'], 'required'],
            [['product_id', 'position'], 'integer'],
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
    public function getProduct()
    {
       return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
