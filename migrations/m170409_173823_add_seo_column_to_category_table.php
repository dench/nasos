<?php

use yii\db\Migration;

/**
 * Handles adding seo to table `category`.
 */
class m170409_173823_add_seo_column_to_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('category_lang', 'seo', 'text');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('category_lang', 'seo');
    }
}
