<?php

use yii\db\Migration;

/**
 * Handles adding filter to table `feature`.
 */
class m170326_154607_add_filter_column_to_feature_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('feature', 'filter', 'boolean not null default 0');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('feature', 'filter');
    }
}
