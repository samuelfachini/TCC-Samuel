<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EstabelecimentoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-estabelecimento-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'estabelecimento_id')->textInput(['placeholder' => '']) ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true, 'placeholder' => '']) ?>

    <?= $form->field($model, 'nr_cpf_cnpj')->textInput(['maxlength' => true, 'placeholder' => '']) ?>

    <?= $form->field($model, 'logradouro')->textInput(['maxlength' => true, 'placeholder' => '']) ?>

    <?= $form->field($model, 'numero')->textInput(['maxlength' => true, 'placeholder' => '']) ?>

    <?php /* echo $form->field($model, 'complemento')->textInput(['maxlength' => true, 'placeholder' => '']) */ ?>

    <?php /* echo $form->field($model, 'bairro')->textInput(['maxlength' => true, 'placeholder' => '']) */ ?>

    <?php /* echo $form->field($model, 'cep')->textInput(['maxlength' => true, 'placeholder' => '']) */ ?>

    <?php /* echo $form->field($model, 'cidade_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\Cidade::find()->orderBy('cidade_id')->asArray()->all(), 'cidade_id', 'nome'),
        'options' => ['placeholder' => Yii::t('app', 'Choose')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) */ ?>

    <?php /* echo $form->field($model, 'telefone_comercial')->textInput(['maxlength' => true, 'placeholder' => '']) */ ?>

    <?php /* echo $form->field($model, 'telefone_celular')->textInput(['maxlength' => true, 'placeholder' => '']) */ ?>

    <?php /* echo $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => '']) */ ?>

    <?php /* echo $form->field($model, 'ativo')->checkbox() */ ?>

    <?php /* echo $form->field($model, 'observacao')->textarea(['rows' => 6]) */ ?>

    <?php /* echo $form->field($model, 'created_at')->textInput(['placeholder' => '']) */ ?>

    <?php /* echo $form->field($model, 'created_by')->textInput(['placeholder' => '']) */ ?>

    <?php /* echo $form->field($model, 'updated_at')->textInput(['placeholder' => '']) */ ?>

    <?php /* echo $form->field($model, 'updated_by')->textInput(['placeholder' => '']) */ ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
