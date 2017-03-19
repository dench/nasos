<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product_status`.
 */
class m170310_185023_create_product_status_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('product_status', [
            'id' => $this->primaryKey(),
            'color' => $this->string(),
            'position' => $this->integer()->notNull()->defaultValue(0),
            'enabled' => $this->boolean()->notNull()->defaultValue(1),
        ]);

        $this->createTable('product_status_lang', [
            'product_status_id' => $this->integer()->notNull(),
            'lang_id' => $this->string(3)->notNull(),
            'name' => $this->string()->notNull(),
        ]);

        $this->addPrimaryKey('pk-product_status_lang', 'product_status_lang', ['product_status_id', 'lang_id']);

        $this->addForeignKey('fk-product_status_lang-product_status_id', 'product_status_lang', 'product_status_id', 'product_status', 'id', 'CASCADE');

        $this->addForeignKey('fk-product_status_lang-lang_id', 'product_status_lang', 'lang_id', 'language', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-product_status_lang-lang_id', 'product_status_lang');

        $this->dropForeignKey('fk-product_status_lang-product_status_id', 'product_status_lang');

        $this->dropPrimaryKey('pk-product_status_lang', 'product_status_lang');

        $this->dropTable('product_status_lang');
        
        $this->dropTable('product_status');
    }
}
