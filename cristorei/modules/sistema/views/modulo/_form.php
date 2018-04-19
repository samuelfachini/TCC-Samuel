<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\sistema\models\Modulo */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="modulo-form well">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->errorSummary($model); ?>


        <?= $form->field($model, 'nome')->textInput(['maxlength' => true, 'placeholder' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
