<?php

use yii\db\Migration;

class m130522_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%image_manager}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(150)->notNull(),
            'id_items' => $this->integer(10)->notNull(),
            'alt' => $this->string(150)->notNull(),
            'class' => $this->string(150),
        ], $tableOptions);
        
	    $this->createTable('{{%tag}}', [
		    'id_tag' => $this->primaryKey(),
		    'title' => $this->string(150)->notNull(),
	    ], $tableOptions);
	    $this->createTable('{{%tagPost}}', [
		    'id' => $this->primaryKey(),
		    'id_tag' => $this->integer(10)->notNull(),
		    'id_post' => $this->integer(10)->notNull(),
	    ], $tableOptions);
	
	    $this->createTable('{{%post}}', [
		    'id_post' => $this->primaryKey(),
		    'id_user' => $this->integer(10),
		    'title' => $this->string(250)->notNull(),
		    'message' => $this->string()->notNull(),
		    'date' => $this->dateTime()->notNull(),
		    'icon' => $this->string(150),
		    'activ' => $this->boolean()->notNull(),
	    ], $tableOptions);
	    $this->createTable('{{%worker}}', [
		    'id' => $this->primaryKey(),
		    'id_user' => $this->integer(10),
		    'name' => $this->string(50)->notNull(),
		    'surname' => $this->string(50)->notNull(),
		    'patronymic' => $this->string(50),
		    'photo' => $this->string()->notNull(),
	    ], $tableOptions);
	
	    $this->addForeignKey(
		    'fk-images-id_items',
		    'image_manager',
		    'id_items',
		    'post',
		    'id_post',
		    'CASCADE'
	    );
	    $this->addForeignKey(
		    'fk-tagPost-id_tag',
		    'tagPost',
		    'id_tag',
		    'tag',
		    'id_tag',
		    'CASCADE'
	    );
	    $this->addForeignKey(
		    'fk-tagPost-id_post',
		    'tagPost',
		    'id_post',
		    'post',
		    'id_post',
		    'CASCADE'
	    );
	    $this->addForeignKey(
		    'fk-worker-id_user',
		    'worker',
		    'id_user',
		    'user',
		    'id',
		    'CASCADE'
	    );
    }

    public function down()
    {
        $this->dropTable('{{%image_manager}}');
	    $this->dropTable('{{%tag}}');
	    $this->dropTable('{{%tagPost}}');
	    $this->dropTable('{{%post}}');
	    $this->dropIndex(
		    'fk-images-id_items',
		    'image_manager'
	    );
	    $this->dropIndex(
		    'fk-tagPost-id_post',
		    'tagPost'
	    );
	    $this->dropIndex(
		    'fk-tagPost-id_tag',
		    'tagPost'
	    );
	    $this->dropIndex(
		    'fk-worker-id_user',
		    'worker');
	
    }
}
