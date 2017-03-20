<?php
/**
 * Created by PhpStorm.
 * User: Dench
 * Date: 28.01.2017
 * Time: 22:40
 */

namespace app\admin\models;

use app\models\File;
use DateTime;
use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class UploadFiles extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $files;

    public $upload;

    private $extensions;
    private $maxSize;
    private $maxFiles;
    private $path;

    public function init()
    {
        parent::init();

        $this->extensions = Yii::$app->params['fileExtensions'];
        $this->maxSize = Yii::$app->params['fileMaxSize'];
        $this->maxFiles = Yii::$app->params['fileMaxFiles'];
        $this->path = Yii::$app->params['filePath'];
    }

    public function rules()
    {
        return [
            [['files'], 'file', 'skipOnEmpty' => false, 'extensions' => $this->extensions, 'maxSize' => $this->maxSize, 'maxFiles' => $this->maxFiles],
        ];
    }

    public function upload()
    {
        $this->upload = [];

        if ($this->validate()) {

            $date = new DateTime();
            $path = $date->format('Y/m/d');

            FileHelper::createDirectory($this->path . '/' .$path);

            foreach ($this->files as $key => $file) {

                $hash = md5_file($file->tempName);
                $type = $file->type;
                $size = $file->size;
                $extension = $file->extension;

                $dub = File::findOne([
                    'hash' => $hash,
                    'size' => $size,
                    'type' => $type,
                    'extension' => $extension,
                ]);

                if (empty($dub)) {
                    $f = new File();
                    $f->hash = $hash;
                    $f->type = $type;
                    $f->size = $size;
                    $f->extension = $extension;
                    $f->path = $path;
                    if ($f->save()) {
                        $file->saveAs($this->path . '/' .$path . '/' . $f->hash . '.' . $f->extension);
                    }
                } else {
                    $f = $dub;
                }

                $f->name = $file->name;

                $this->upload[$key]['file'] = $f;

                if (preg_match('#^image/#', $f->type)) {
                    $image = new \app\models\Image();
                    $image->file_id = $f->id;
                    $image->name = $f->name;
                    $img = \yii\imagine\Image::getImagine()->open($this->path . '/' .$f->path . '/' . $f->hash . '.' . $f->extension);
                    $image->width = $img->getSize()->getWidth();
                    $image->height = $img->getSize()->getHeight();
                    $image->save();

                    $this->upload[$key]['image'] = $image;
                }
            }

            return $this->upload;
        } else {
            return false;
        }
    }
}