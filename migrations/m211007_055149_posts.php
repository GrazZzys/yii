<?php

use yii\db\Migration;

/**
 * Class m211007_055149_posts
 */
class m211007_055149_posts extends Migration
{

    /*
    public function safeUp()
    {

    }

    public function safeDown()
    {
        echo "m211007_055149_posts cannot be reverted.\n";

        return false;
    }
    */

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('posts', [
            'id' => $this->primaryKey(),
            'title' => $this->string(50)->notNull(),
            'text' => $this->text(),
            'author' => $this->integer(),
        ]);

        $this->createIndex('posts_id','posts', 'id');
        $this->createIndex('posts_title','posts', 'title');
    }

    public function down()
    {
        echo "m211007_055149_posts cannot be reverted.\n";

        return false;
    }

}
