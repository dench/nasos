<?php

namespace app\models;

use Imagine\Image\Box;
use Imagine\Image\Point;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "image".
 *
 * @property integer $id
 * @property integer $file_id
 * @property string $method
 * @property string $name
 * @property string $alt
 * @property integer $rotate
 * @property integer $mirror
 * @property integer $width
 * @property integer $height
 * @property integer $x
 * @property integer $y
 * @property integer $zoom
 * @property integer $watermark
 *
 * @property File $file
 */
class Image extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file_id', 'name', 'width', 'height'], 'required'],
            [['file_id', 'rotate', 'mirror', 'width', 'height', 'x', 'y', 'zoom', 'watermark'], 'integer'],
            [['method'], 'string', 'max' => 10],
            [['name', 'alt'], 'string', 'max' => 255],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_id' => Yii::t('app', 'File'),
            'method' => Yii::t('app', 'Method'),
            'name' => Yii::t('app', 'Name'),
            'alt' => Yii::t('app', 'Alt'),
            'rotate' => Yii::t('app', 'Rotate'),
            'mirror' => Yii::t('app', 'Mirror'),
            'width' => Yii::t('app', 'Width'),
            'height' => Yii::t('app', 'Height'),
            'x' => Yii::t('app', 'X'),
            'y' => Yii::t('app', 'Y'),
            'zoom' => Yii::t('app', 'Zoom'),
            'watermark' => Yii::t('app', 'Watermark'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::className(), ['id' => 'file_id']);
    }

    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        parent::afterDelete();

        foreach (Yii::$app->params['imageCache'] as $size) {
            $file = Yii::$app->basePath . '/web/' . Yii::$app->params['imagesDir'] . '/' . $size['dir'] . '/' . $this->id . '.jpg';
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }

    public static function resize($id, $size)
    {
        if (!$model = self::findOne($id)) return false;

        $param = Yii::$app->params['imageCache'][$size];

        $original = Yii::$app->params['filePath'] . '/' . $model->file->path . '/' . $model->file->hash . '.jpg';
        $thumb = Yii::$app->basePath . '/web/' . Yii::$app->params['imagesDir'] . '/' . Yii::$app->params['imageCache'][$size]['dir'] . '/' . $id . '.jpg';

        $img = \yii\imagine\Image::getImagine()->open($original);
        $size = $img->getSize();

        $k1 = $param['width']/$size->getWidth();
        $k2 = $param['height']/$size->getHeight();
        $k = $k1 > $k2 ? $k1 : $k2;
        $width = round($size->getWidth()*$k);
        $height = round($size->getHeight()*$k);
        $x = -round(($param['width']-$width)/2);
        $y = -round(($param['height']-$height)/2);

        if ($param['width'] < 300) $wm = Yii::$app->params['watermarkThumb']; else $wm = Yii::$app->params['watermark'];
        $watermark = \yii\imagine\Image::getImagine()->open($wm['file']);
        $wSize = $watermark->getSize();
        $bottomRight = new Point($param['width'] - $wSize->getWidth() - $wm['x'], $param['height'] - $wSize->getHeight() - $wm['y']);

        if ($img->resize(new Box($width, $height))
            ->crop(new Point($x, $y), new Box($param['width'], $param['height']))
            ->paste($watermark, $bottomRight)
            ->save($thumb))
        {
            return $thumb;
        } else {
            return false;
        }
    }
}
