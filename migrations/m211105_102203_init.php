<?php

use yii\db\Migration;

/**
 * Class m211105_102203_init
 */
class m211105_102203_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('CREATE TABLE `comments` (`id` int(11) NOT NULL AUTO_INCREMENT,`text` text NOT NULL,`user` varchar(100) NOT NULL, `parent_id` int(11) DEFAULT NULL,`date` datetime DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('comments');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211105_102203_init cannot be reverted.\n";

        return false;
    }
    */
}
