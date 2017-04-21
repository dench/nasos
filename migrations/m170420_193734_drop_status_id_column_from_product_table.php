<?php

use yii\db\Migration;

/**
 * Handles dropping status_id from table `product`.
 */
class m170420_193734_drop_status_id_column_from_product_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropForeignKey('fk-product-status_id', 'product');

        $this->dropColumn('product', 'status_id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addColumn('product', 'status_id', 'integer');

        $this->addForeignKey('fk-product-status_id', 'product', 'status_id', 'product_status', 'id', 'SET NULL');
    }
}
