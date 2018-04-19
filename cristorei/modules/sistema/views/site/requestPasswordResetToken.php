<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app','Solicitação de reset de senha');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

                <?= $form->field($model, 'email')->textInput()->label('E-mail') ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app','Solicitar'), ['class' => 'btn btn-primary btn-block']) ?>
                </div>

            <?php ActiveForm::end(); ?>

             <p><?= Yii::t('app','Por favor, preencha o campo acima com o seu e-mai. Um link para resetar a senha será enviado para o seu e-mail.') ?></p>
            </div>
        </div>
    </div>
</div>