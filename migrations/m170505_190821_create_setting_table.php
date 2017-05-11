<?php

use yii\db\Migration;

/**
 * Handles the creation of table `setting`.
 */
class m170505_190821_create_setting_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('setting', [
            'id' => $this->string()->notNull(),
        ], $tableOptions);

        $this->createTable('setting_lang', [
            'setting_id' => $this->string()->notNull(),
            'lang_id' => $this->string(3)->notNull(),
            'name' => $this->string()->notNull(),
            'value' => $this->text()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('pk-setting', 'setting', 'id');

        $this->addPrimaryKey('pk-setting_lang', 'setting_lang', ['setting_id', 'lang_id']);

        $this->addForeignKey('fk-setting_lang-setting_id', 'setting_lang', 'setting_id', 'setting', 'id', 'CASCADE');

        $this->addForeignKey('fk-setting_lang-lang_id', 'setting_lang', 'lang_id', 'language', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-setting_lang-lang_id', 'setting_lang');

        $this->dropForeignKey('fk-setting_lang-setting_id', 'setting_lang');

        $this->dropPrimaryKey('pk-setting_lang', 'setting_lang');

        $this->dropPrimaryKey('pk-setting-id', 'setting');

        $this->dropTable('setting_lang');

        $this->dropTable('setting');
    }
}
