<?php

use app\models\Image;
use yii\db\Migration;
use yii\helpers\StringHelper;

class m170325_131347_remove_extension_image_name extends Migration
{
    public function up()
    {
        $images = Image::find()->all();

        foreach ($images as $image) {
            $image->detachBehaviors();
            echo "\nRename from " . $image->name;
            $image->name = StringHelper::basename($image->name, '.' . ($image->file->extension));
            $image->save();
            echo " to " . $image->name;
        }

        echo "\n";
    }

    public function down()
    {
        $images = Image::find()->all();

        foreach ($images as $image) {
            $image->detachBehaviors();
            echo "\nRename from " . $image->name;
            $image->name = $image->name . '.' . $image->file->extension;
            $image->save();
            echo " to " . $image->name;
        }

        echo "\n";
    }
}
