<?php

use yii\db\Migration;

class m130524_201542_user extends Migration
{
    public function up()
    {
        $estabelecimento = '{{%estabelecimento}}';
        $user            = '{{%user}}';

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($user, [
            'id' => $this->primaryKey(),
            'estabelecimento_id' => $this->integer()->notNull(),
            'username' => $this->string()->notNull()->unique(),
            'name' => $this->string(120)->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'tipo' => $this->boolean()->notNull(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'permite_acesso_externo' => $this->boolean()->notNull()->defaultValue(0),
            'data_ultimo_login' => $this->integer(),
            'ip_ultimo_login' => 'CHAR(15)',
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ], $tableOptions);


        $this->addForeignKey('fk_user_estabelecimento', $user, 'estabelecimento_id', $estabelecimento, 'estabelecimento_id');

        $this->insert($user,[
            'estabelecimento_id' => 1,
            'username' => 'admin@admin.com',
            'tipo' => 9,
            'name'=> 'Administrador',
            'password_hash' => Yii::$app->security->generatePasswordHash('123456'),
            'auth_key' => Yii::$app->security->generateRandomString(),
            'created_at' => time(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
