<?php

use yii\db\Migration;

/**
 * Handles adding price_from to table `product`.
 */
class m170402_164805_add_price_from_column_to_product_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('product', 'price_from', 'boolean not null default 0');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('product', 'price_from');
    }
}
