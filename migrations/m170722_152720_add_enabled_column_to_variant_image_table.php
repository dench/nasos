<?php

use yii\db\Migration;

/**
 * Handles adding enabled to table `variant_image`.
 */
class m170722_152720_add_enabled_column_to_variant_image_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('variant_image', 'enabled', 'boolean not null default 1');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('variant_image', 'enabled');
    }
}
