<?php

namespace app\models;

use himiklab\yii2\recaptcha\ReCaptchaValidator;
use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $text;
    public $reCaptcha;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email and body are required
            [['name', 'email', 'text'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            [['reCaptcha'], ReCaptchaValidator::className(), 'uncheckedMessage' => 'Please confirm that you are not a bot.']
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Your name'),
            'email' => Yii::t('app', 'Your E-mail'),
            'text' => Yii::t('app', 'Text'),
            'reCaptcha' => Yii::t('app', 'Verification'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function contact($email)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([$this->email => $this->name])
                ->setSubject(Yii::t('app', 'Feedback'))
                ->setTextBody($this->body)
                ->send();

            return true;
        }
        return false;
    }
}
