<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Estabelecimento */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="estabelecimento-form well">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->errorSummary($model); ?>


    <?= $form->field($model, 'nome')->textInput(['maxlength' => true, 'placeholder' => '']) ?>

    <?= $form->field($model, 'nr_cpf_cnpj', ['enableAjaxValidation' => false])->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '99.999.999/9999-99',
    ]) ?>

    <?= $form->field($model, 'responsavel')->textInput(['maxlength' => true, 'placeholder' => '']) ?>

    <?= $form->field($model, 'nr_cpf_responsavel', ['enableAjaxValidation' => false])->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '999.999.999-99',
    ]) ?>

    <?= $form->field($model, 'logradouro')->textInput(['maxlength' => true, 'placeholder' => '']) ?>

    <?= $form->field($model, 'numero')->textInput(['maxlength' => true, 'placeholder' => '']) ?>

    <?= $form->field($model, 'complemento')->textInput(['maxlength' => true, 'placeholder' => '']) ?>

    <?= $form->field($model, 'bairro')->textInput(['maxlength' => true, 'placeholder' => '']) ?>

    <?= $form->field($model, 'cep')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '99999-999',
    ]) ?>

    <?= $form->field($model, 'cidade_id')->widget(Select2::classname(), [
        'initValueText' => \app\modules\sistema\models\Cidade::obterCidadeComSiglaUF($model->cidade_id),
        'options' => ['placeholder' => Yii::t('app','Choose'). ' ...'],
        'language' => 'pt-BR',
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 3,
            'ajax' => [
                'url' => \yii\helpers\Url::to(['cidade/listar-cidades']),
                'dataType' => 'json',
            ],
        ],
    ]); ?>

    <?= $form->field($model, 'telefone_comercial')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => ['(99) 9999-9999', '(99) 99999-9999'],
    ]) ?>

    <?= $form->field($model, 'telefone_celular')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => ['(99) 9999-9999', '(99) 99999-9999'],
    ]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => '']) ?>

    <?= $form->field($model, 'ip_local')->widget(\yii\widgets\MaskedInput::className(), [
        'clientOptions' => [
            'alias' =>  'ip'
        ],
    ]) ?>

    <?= $form->field($model, 'ativo')->checkbox() ?>

    <?= $form->field($model, 'observacao')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
