<?php

use yii\widgets\DetailView;
use yii\bootstrap5\Html;

/** @var $model app\models\User */

$this->title = 'User Details';
?>

<div class="container mt-4">

    <h1 class="mb-4"><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-bordered'],
        'attributes' => [
            'id',
            'name',
            'email',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

    <div class="mt-3">
        <?= Html::a('Edit', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this user?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Back to Users', ['index'], ['class' => 'btn btn-outline-secondary ms-2']) ?>
    </div>

</div>
