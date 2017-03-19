<?php

namespace app\models;

use dench\language\behaviors\LanguageBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "value".
 *
 * @property integer $id
 * @property integer $name
 * @property integer $feature_id
 *
 * @property Feature $feature
 */
class Value extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'value';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            LanguageBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['feature_id', 'name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['feature_id'], 'integer'],
            [['feature_id'], 'exist', 'skipOnError' => true, 'targetClass' => Feature::className(), 'targetAttribute' => ['feature_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'feature_id' => Yii::t('app', 'Feature'),
            'name' => Yii::t('app', 'Name'),
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
    public function getFeature()
    {
        return $this->hasOne(Feature::className(), ['id' => 'feature_id']);
    }

    /**
     * @param boolean|null $enabled
     * @return array
     */
    public static function getList($feature_id)
    {
        return ArrayHelper::map(self::find()->andFilterWhere(['feature_id' => $feature_id])->all(), 'id', 'name');
    }
}
