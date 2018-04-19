<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\checkbox\CheckboxX;
use app\modules\sistema\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<p>&nbsp;</p>

<div class="user-form well">

    <?php $form = ActiveForm::begin([
            'id' => 'form-user',
            'layout' => 'horizontal',
        ]
    );
    ?>

    <?= $form->errorSummary($model); ?>

    <?php
    if (Yii::$app->user->identity->isMaster) {

        echo $form->field($model, 'estabelecimento_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(app\modules\sistema\models\Estabelecimento::find()->all(), 'estabelecimento_id', 'nome'),
            ['prompt' => '']
        );
    }
    ?>

    <?= $form->field($model, 'name',['inputOptions' =>
        ['placeholder' => Yii::t('app','ex. João da Silva')]])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'username',['enableAjaxValidation' => true, 'inputOptions' =>
        ['placeholder' => Yii::t('app','insira um e-mail válido')]])->textInput(['maxlength' => true]) ?>


    <?php if ($model->scenario == User::SCENARIO_UPDATE_PASS) { ?>
        <?= $form->field($model, 'current_password',['enableAjaxValidation' => true])->passwordInput(['maxlength' => true]) ?>
    <?php } ?>


    <?php if ($model->scenario !== User::SCENARIO_MANTER_RESPONSAVEL) { ?>

        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>

    <?php } ?>

    <?= $form->field($model, 'num_tel')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => ['(99) 99999-9999','(99) 999999-9999'],
    ]) ?>
    <?= $form->field($model, 'num_cel')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => ['(99) 99999-9999','(99) 999999-9999'],
    ]) ?>

    <?php if ((Yii::$app->user->can(User::TIPO_ADMINISTRADOR)) && ($model->scenario !== User::SCENARIO_MANTER_RESPONSAVEL)) { ?>
        <?= $form->field($model, 'tipo')->dropDownList(User::optsTipoUsuario()) ?>
        <?= $form->field($model, 'status')->dropDownList([0 => 'Não',10 => 'Sim']) ?>
    <?php } ?>

<?php if (!Yii::$app->request->isAjax): ?>
    <div class="form-group">
        <div class="col-sm-6 col-lg-offset-3">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
<?php endif; ?>

    <?php ActiveForm::end(); ?>

</div>