<?php

use yii\db\Migration;

/**
 * Handles the creation of table `block`.
 */
class m170811_083803_create_block_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('block', [
            'id' => $this->primaryKey(),
            'name' => $this->string(32)->unique()->notNull(),
            'controller' => $this->string(),
            'enabled' => $this->boolean()->notNull()->defaultValue(1),
        ], $tableOptions);

        $this->createTable('block_lang', [
            'block_id' => $this->integer()->notNull(),
            'lang_id' => $this->string(3)->notNull(),
            'html' => $this->text(),
        ], $tableOptions);

        $this->addPrimaryKey('pk_block_lang', 'block_lang', ['block_id', 'lang_id']);

        $this->addForeignKey('fk-block_lang-block_id', 'block_lang', 'block_id', 'block', 'id', 'CASCADE');

        $this->addForeignKey('fk-block_lang-lang_id', 'block_lang', 'lang_id', 'language', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropPrimaryKey('pk_block_lang', 'block_lang');

        $this->dropForeignKey('fk-block_lang-block_id', 'block_lang');

        $this->dropForeignKey('fk-block_lang-lang_id', 'block_lang');

        $this->dropTable('block_lang');

        $this->dropTable('block');
    }
}
