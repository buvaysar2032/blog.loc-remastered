<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%code}}`.
 */
class m241106_073909_create_code_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    final public function safeUp()
    {
        $this->createTable('{{%code}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(6),
            'promocode' => $this->string(),
            'code_category_id' => $this->integer(),
            'user_id' => $this->integer(),
            'taken_at' => $this->integer(),
            'user_ip' => $this->integer(),
            'public_status' => $this->boolean()->defaultValue(0)
        ]);

        $this->addForeignKey(
            'fk-code-code_category_id',
            'code',
            'code_category_id',
            'code_category',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    final public function safeDown()
    {
        $this->dropForeignKey(
            'fk-code-code_category_id',
            'code'
        );

        $this->dropTable('{{%code}}');
    }
}
