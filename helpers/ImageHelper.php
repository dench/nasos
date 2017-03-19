<?php
/**
 * Created by PhpStorm.
 * User: Dench
 * Date: 29.01.2017
 * Time: 20:20
 */

namespace app\helpers;

use app\models\Image;
use Yii;

class ImageHelper
{
    public static function big($image_id)
    {
        return self::size($image_id, 'big');
    }

    public static function normal($image_id)
    {
        return self::size($image_id, 'normal');
    }

    public static function small($image_id)
    {
        return self::size($image_id, 'small');
    }

    public static function cover($image_id)
    {
        return self::size($image_id, 'cover');
    }

    public static function size($image_id, $size)
    {
        return '/' . Yii::$app->params['imagesDir'] . '/' . Yii::$app->params['imageCache'][$size]['dir'] . '/' . $image_id . '.jpg?i=' . self::hash($image_id);
    }

    private static function hash($image_id)
    {
        $image = Image::findOne($image_id);

        return substr(md5(
            $image->method .
            $image->rotate .
            $image->mirror .
            $image->x .
            $image->y .
            $image->zoom
        ), 0, 6);
    }
}