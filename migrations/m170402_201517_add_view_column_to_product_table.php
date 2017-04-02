<?php

use yii\db\Migration;

/**
 * Handles adding view to table `product`.
 */
class m170402_201517_add_view_column_to_product_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('product', 'view', 'string');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('product', 'view');
    }
}
