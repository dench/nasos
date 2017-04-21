<?php

use yii\db\Migration;

class m170420_192029_rename_product_status_table extends Migration
{
    public function up()
    {
        $this->renameTable('product_status', 'status');

        $this->renameTable('product_status_lang', 'status_lang');

        $this->renameColumn('status_lang', 'product_status_id', 'status_id');
    }

    public function down()
    {
        $this->renameTable('status', 'product_status');

        $this->renameTable('status_lang', 'product_status_lang');

        $this->renameColumn('product_status_lang', 'status_id', 'product_status_id');
    }
}
