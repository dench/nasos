<?php

use yii\db\Migration;

/**
 * Handles the creation of table `complect`.
 */
class m170319_131748_create_complect_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('complect', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'position' => $this->integer()->notNull()->defaultValue(0),
        ]);

        $this->createTable('complect_lang', [
            'complect_id' => $this->integer()->notNull(),
            'lang_id' => $this->string(3)->notNull(),
            'name' => $this->string()->notNull(),
        ]);

        $this->addPrimaryKey('pk-complect_lang', 'complect_lang', ['complect_id', 'lang_id']);

        $this->addForeignKey('fk-complect_lang-complect_id', 'complect_lang', 'complect_id', 'complect', 'id', 'CASCADE');

        $this->addForeignKey('fk-complect_lang-lang_id', 'complect_lang', 'lang_id', 'language', 'id', 'CASCADE', 'CASCADE');

        $this->addForeignKey('fk-complect-product_id', 'complect', 'product_id', 'product', 'id', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-complect-product_id', 'complect');

        $this->dropForeignKey('fk-complect_lang-lang_id', 'complect_lang');

        $this->dropForeignKey('fk-complect_lang-complect_id', 'complect_lang');

        $this->dropPrimaryKey('pk-complect_lang', 'complect_lang');

        $this->dropTable('complect_lang');

        $this->dropTable('complect');
    }
}
