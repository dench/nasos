<?php

use yii\db\Migration;

/**
 * Handles the creation of table `language`.
 */
class m161028_105921_create_language_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('language', [
            'id' => $this->string(3)->notNull(),
            'name' => $this->string(31)->notNull(),
            'position' => $this->smallInteger()->defaultValue(0),
            'enabled' => $this->boolean()->notNull()->defaultValue(1)
        ], $tableOptions);

        $this->addPrimaryKey('id', 'language', 'id');

        $this->batchInsert('language', ['id', 'name', 'position'], [
            ['uk', 'Українська', 1],
            ['ru', 'Русский', 2],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('language');
    }
}
