<?php

use yii\db\Migration;

/**
 * Handles the creation of table `questionnaire`.
 */
class m180721_131839_create_questionnaire_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('questionnaire', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'phone' => $this->string()->notNull(),
            'type' => $this->integer()->notNull(),
            'section' => $this->integer(),
            'fuel' => $this->integer(),
            'performance' => $this->string(),
            'supply' => $this->string(),
            'level' => $this->integer(),
            'status' => $this->integer()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('questionnaire');
    }
}
