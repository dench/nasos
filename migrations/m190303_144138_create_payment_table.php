<?php

use yii\db\Migration;

/**
 * Handles the creation of table `payment`.
 */
class m190303_144138_create_payment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('payment', [
            'id' => $this->primaryKey(),
            'position' => $this->integer()->notNull()->defaultValue(0),
            'enabled' => $this->boolean()->notNull()->defaultValue(1),
        ], $tableOptions);
        
        $this->createTable('payment_lang', [
            'payment_id' => $this->integer()->notNull(),
            'lang_id' => $this->string(3)->notNull(),
            'name' => $this->string()->notNull(),
            'text' => $this->text(),
        ], $tableOptions);

        $this->addPrimaryKey('pk-payment_lang', 'payment_lang', ['payment_id', 'lang_id']);

        $this->addForeignKey('fk-payment_lang-payment_id', 'payment_lang', 'payment_id', 'payment', 'id', 'CASCADE');

        $this->addForeignKey('fk-payment_lang-lang_id', 'payment_lang', 'lang_id', 'language', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropPrimaryKey('pk-payment_lang', 'payment_lang');

        $this->dropForeignKey('fk-payment_lang-payment_id', 'payment_lang');

        $this->dropForeignKey('fk-payment_lang-lang_id', 'payment_lang');

        $this->dropTable('payment_lang');
        
        $this->dropTable('payment');
    }
}
