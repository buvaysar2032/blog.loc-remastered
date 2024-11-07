<?php

use yii\db\Migration;

/**
 * Class m241107_074955_add_index_to_code_table
 */
class m241107_074955_add_index_to_code_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-code-public_status-code', // имя индекса
            'code',
            ['public_status', 'code']
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-code-public_status-code', 'code');
    }
}
