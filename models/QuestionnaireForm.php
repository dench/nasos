<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 29.07.18
 * Time: 18:09
 */

namespace app\models;

use himiklab\yii2\recaptcha\ReCaptchaValidator;
use Yii;

class QuestionnaireForm extends Questionnaire
{
    public $reCaptcha;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['reCaptcha'], ReCaptchaValidator::className(), 'uncheckedMessage' => Yii::t('app','Please confirm that you are not a bot.')],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'reCaptcha' => Yii::t('questionnaire', 'reCaptcha'),
        ]);
    }

    public function send()
    {
        if ($this->save()) {
            return true;
        } else {
            return false;
        }
    }

    public static function typeList()
    {
        return [
            1 => Yii::t('questionnaire', 'there is a reservoir, only a column is needed'),
            2 => Yii::t('questionnaire', 'there is no reservoir, a modular gas station (reservoir and column) is needed'),
            3 => Yii::t('questionnaire', 'you need a container filling station (a container in a container and a column)'),
        ];
    }

    public static function sectionList()
    {
        return [
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
        ];
    }

    public static function fuelList()
    {
        return [
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
        ];
    }

    public static function performanceList()
    {
        return [
            1 => 50,
            2 => 80,
            3 => 130,
        ];
    }

    public static function supplyList()
    {
        return [
            1 => Yii::t('questionnaire', 'without preliminary dose'),
            2 => Yii::t('questionnaire', 'preliminary dose set'),
            3 => Yii::t('questionnaire', 'sending on cards with data transfer to the computer'),
        ];
    }

    public static function levelList()
    {
        return [
            1 => Yii::t('questionnaire', 'metrost'),
            2 => Yii::t('questionnaire', 'electronic level gauge'),
        ];
    }
}