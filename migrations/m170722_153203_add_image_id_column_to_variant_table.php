<?php

use yii\db\Migration;

/**
 * Handles adding image_id to table `variant`.
 */
class m170722_153203_add_image_id_column_to_variant_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('variant', 'image_id', 'integer');

        $this->createIndex('idx-variant-image_id','variant', 'image_id');

        $this->addForeignKey('fk-variant-image_id', 'variant', 'image_id', 'image', 'id', 'SET NULL');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-variant-image_id', 'variant');

        $this->dropIndex('idx-variant-image_id', 'variant');

        $this->dropColumn('variant', 'image_id');
    }
}
