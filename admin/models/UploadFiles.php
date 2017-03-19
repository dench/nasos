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
                $f = new File();
                $f->hash = md5_file($file->tempName);
                $f->type = $file->type;
                $f->size = $file->size;
                $f->extension = $file->extension;
                $f->name = $file->name;

                $dub = File::findOne([
                    'hash' => $f->hash,
                    'size' => $f->size,
                    'type' => $f->type,
                    'extension' => $f->extension,
                ]);

                if (empty($dub)) {
                    $f->path = $path;
                    if ($f->save()) {
                        $file->saveAs($this->path . '/' .$path . '/' . $f->hash . '.' . $f->extension);
                    }
                } else {
                    $f->path = $dub->path;
                    $f->save();
                }

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