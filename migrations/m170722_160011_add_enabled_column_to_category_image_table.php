<?php

use yii\db\Migration;

/**
 * Handles adding enabled to table `category_image`.
 */
class m170722_160011_add_enabled_column_to_category_image_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('category_image', 'enabled', 'boolean not null default 1');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('category_image', 'enabled');
    }
}
