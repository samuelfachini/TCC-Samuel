<?php

namespace app\models;

use app\components\ABHelpers;
use Yii;
use \app\models\base\BaseSepultura;
use yii\db\Query;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;

/**
 * This is the model class for table "sepultura".
 */
class Sepultura extends BaseSepultura
{
    const PASTA_IMAGENS = 'fotos/';

    /**
     * @var UploadedFile
     */
    public $imagem;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['numero'], 'unique', 'targetAttribute' => ['quadra_id','numero','sufixo_numero'], 'message' => Yii::t('app','Já existe sepultura cadastrada para esta quadra, número e sufixo.')], //Regra unica para 2 colunas
            [['imagem'], 'file', 'skipOnEmpty' => true, 'maxSize' => 5*1024*1024],
            ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_replace_recursive(parent::attributeLabels(), [
            'user_id' => Yii::t('app', 'Responsável'),
        ]);
    }

    public function obterDescricaoSepultura()
    {
        return $this->quadra->nome . ' A'. $this->aleia . ' N'. $this->numero  . $this->sufixo_numero;
    }

    public function obterNumeroComSufixo()
    {
        return $this->numero . ' ' .$this->sufixo_numero;
    }

    public function obterFalecidos()
    {
        $falecidos = (new Query())
            ->select("CASE WHEN nome IS NULL OR nome = '' THEN '(?????)' ELSE nome END AS nome")
            ->from('falecido')
            ->where(['sepultura_id' => $this->sepultura_id])
            ->orderBy('nome')
            ->column();

        return implode($falecidos,' / ');
    }

    public function uploadImagem()
    {
        if (!$this->imagem)
            return;

        //VarDumper::dump($this->imagem,10, true);die;

        $pasta_foto = 'q'.$this->quadra->quadra_id;

        $caminho_completo = static::PASTA_IMAGENS.
            $pasta_foto.'/'.
            $pasta_foto.'a'.$this->aleia.'s'.$this->numero.'.JPG';

        \Yii::beginProfile('salvandoFoto_'.$caminho_completo);

        Image::getImagine()
            ->open($this->imagem->tempName)
            ->rotate(ABHelpers::obterCorrecaoOrientacaoImagem($this->imagem->tempName))
            ->thumbnail(new Box(600, 800))
            ->save($caminho_completo);

        unlink($this->imagem->tempName);

        \Yii::endProfile('salvandoFoto_'.$caminho_completo);
    }
}