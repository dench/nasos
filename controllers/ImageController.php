<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 11.03.17
 * Time: 23:41
 */

namespace app\controllers;

use app\models\Image;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ImageController extends Controller
{
    public function actionPhoto($id, $size)
    {
        if ($file = Image::resize($id, $size)) {
            header('Content-Type: image/jpeg');
            print file_get_contents($file);
        } else {
            throw new NotFoundHttpException('Photo not found!');
        }
        die();
    }

}