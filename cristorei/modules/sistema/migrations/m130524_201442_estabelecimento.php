<?php

use yii\db\Migration;

class m130524_201442_estabelecimento extends Migration
{
    public function up()
    {
        $estabelecimento = '{{%estabelecimento}}';

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($estabelecimento, [
            'estabelecimento_id' => $this->primaryKey(),
            'nome' => $this->string(150)->notNull(),
            'nr_cpf_cnpj' => $this->string(18),
            'responsavel' => $this->string(100),
            'nr_cpf_responsavel' => $this->string(14),
            'logradouro' => $this->string(255),
            'numero' => $this->string(10),
            'complemento' => $this->string(45),
            'bairro' => $this->string(60),
            'cep' => 'CHAR(9)',
            'cidade_id' => $this->integer(4)->notNull(),
            'telefone_comercial' => $this->string(15),
            'telefone_celular' => $this->string(15),
            'email' => $this->string(100),
            'ip_local' => 'CHAR(15)',
            'ativo' => $this->boolean()->notNull()->defaultValue(1),
            'observacao' => $this->text(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey('fk_estabelecimento_cidade', $estabelecimento, 'cidade_id', 'cidade', 'cidade_id');

        $this->insert($estabelecimento,['nome' => 'Estabelecimento Padrão','cidade_id' => 4628, 'created_at' => time()]);
    }

    public function down()
    {
        $this->dropTable('{{%estabelecimento}}');
    }
}
