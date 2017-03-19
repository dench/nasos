<?php

use yii\db\Migration;

class m170319_120305_add_column_main_to_category_table extends Migration
{
    public function up()
    {
        $this->addColumn('category', 'main', 'boolean not null default 0');
    }

    public function down()
    {
        $this->dropColumn('category', 'main');
    }
}
