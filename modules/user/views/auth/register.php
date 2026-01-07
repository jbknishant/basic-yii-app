<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\modules\user\models\SignupForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Register';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-register">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to register:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'form-register',
    ]); ?>

        <?= $form->field($model, 'name')->textInput([
            'autofocus' => true,
            'maxlength' => true,
        ]) ?>

        <?= $form->field($model, 'email')->input('email') ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <div class="form-group mt-3">
            <?= Html::submitButton('Register', [
                'class' => 'btn btn-primary',
                'name' => 'register-button',
            ]) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
