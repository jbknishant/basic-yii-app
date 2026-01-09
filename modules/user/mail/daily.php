<?php
/** @var app\models\User $user */
?>

Hello <?= $user->name ?>,

This is your daily test mail  email from <?= Yii::$app->name ?>.
Ignore this email if you did not request it.

Regards,  
Team <?= Yii::$app->name ?>
