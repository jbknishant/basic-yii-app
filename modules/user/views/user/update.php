<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/** @var $model app\models\User */

$this->title = 'Update User';
?>

<div class="container mt-4">

    <h1 class="mb-4"><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput() ?>
        <?= $form->field($model, 'email')->textInput() ?>
        <?= $form->field($model, 'password')
            ->passwordInput()
            ->hint('Leave blank if you do not want to change password') ?>

        <?= $form->field($model, 'confirm_password')->passwordInput() ?>

        <div class="mt-3">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-secondary ms-2']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
