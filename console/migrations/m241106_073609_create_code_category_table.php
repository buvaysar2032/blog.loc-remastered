<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%code_category}}`.
 */
class m241106_073609_create_code_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    final public function safeUp()
    {
        $this->createTable('{{%code_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    final public function safeDown()
    {
        $this->dropTable('{{%code_category}}');
    }
}
