<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "questionnaire".
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property int $type
 * @property int $section
 * @property int $fuel
 * @property array $performance
 * @property array $supply
 * @property int $level
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class Questionnaire extends ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_NEW = 1;
    const STATUS_READ = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'questionnaire';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'type'], 'required'],
            [['type', 'section', 'fuel', 'level', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'phone'], 'string', 'max' => 255],
            [['performance', 'supply'], 'each', 'rule' => ['in', 'range' => [1, 2, 3, 4]]],
            ['status', 'default', 'value' => self::STATUS_NEW],
            ['status', 'in', 'range' => [self::STATUS_DELETED, self::STATUS_NEW, self::STATUS_READ]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('questionnaire', 'What is your name?'),
            'phone' => Yii::t('questionnaire', 'Contact number:'),
            'type' => Yii::t('questionnaire', 'What type of equipment are you interested in?'),
            'section' => Yii::t('questionnaire', 'Number of sections in the tank:'),
            'fuel' => Yii::t('questionnaire', 'Number of fuels:'),
            'performance' => Yii::t('questionnaire', 'Performance of the column l/min:'),
            'supply' => Yii::t('questionnaire', 'Fuel supply system:'),
            'level' => Yii::t('questionnaire', 'Measurement of the fuel level at the filling station:'),
            'status' => Yii::t('questionnaire', 'Status'),
            'created_at' => Yii::t('questionnaire', 'Created'),
            'updated_at' => Yii::t('questionnaire', 'Updated'),
        ];
    }

    public static function statusList()
    {
        return [
            self::STATUS_DELETED => Yii::t('questionnaire', 'Deleted'),
            self::STATUS_NEW => Yii::t('questionnaire', 'New'),
            self::STATUS_READ => Yii::t('questionnaire', 'Read'),
        ];
    }

    public function beforeSave($insert)
    {
        $this->performance = implode($this->performance, ', ');

        $this->supply = implode($this->supply, ', ');

        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->performance = explode(', ', $this->attributes['performance']);

        $this->supply = explode(', ', $this->attributes['supply']);
    }

    public static function unread()
    {
        return self::find()->where(['status' => self::STATUS_NEW])->count();
    }

    public static function read($id = null)
    {
        /** @var $temp Questionnaire[] */
        $temp = self::find()->where(['status' => self::STATUS_NEW])->andFilterWhere(['id' => $id])->all();

        foreach ($temp as $t) {
            $t->status = self::STATUS_READ;
            $t->save();
        }
    }
}
