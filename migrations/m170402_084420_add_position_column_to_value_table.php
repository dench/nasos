<?php

use yii\db\Migration;

/**
 * Handles adding position to table `value`.
 */
class m170402_084420_add_position_column_to_value_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('value', 'position', 'integer not null default 0');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('value', 'position');
    }
}
