<?php

use yii\db\Migration;

/**
 * Handles dropping filter from table `feature`.
 */
class m170504_185314_drop_filter_column_from_feature_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropColumn('feature', 'filter');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addColumn('feature', 'filter', 'boolean not null default 0');
    }
}
