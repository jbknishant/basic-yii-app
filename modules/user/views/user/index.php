<?php

use yii\grid\GridView;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/** @var $searchModel app\modules\user\models\UserSearch */
/** @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
?>

<div class="container mt-4">

    <h1 class="mb-4"><?= Html::encode($this->title) ?></h1>

    <!-- 🔍 Search Filters -->
    <div class="card mb-4">
        <div class="card-body">

            <?php $form = ActiveForm::begin([
                'method' => 'get',
            ]); ?>

            <div class="row">
                <div class="col-md-5">
                    <?= $form->field($searchModel, 'name')->textInput([
                        'placeholder' => 'Search by name',
                    ]) ?>
                </div>

                <div class="col-md-5">
                    <?= $form->field($searchModel, 'email')->textInput([
                        'placeholder' => 'Search by email',
                    ]) ?>
                </div>

                <div class="col-md-2 d-flex align-items-end mb-3">
                    <?= Html::submitButton('Search', ['class' => 'btn btn-primary me-2']) ?>
                    <?= Html::a('Reset', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

    <!-- 📋 User Table -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped table-bordered'],
        'layout' => "{items}\n<div class='d-flex justify-content-center mt-4'>{pager}</div>",
        'pager' => [
            'class' => \yii\bootstrap5\LinkPager::class,
            'options' => ['class' => 'pagination'],
            'linkContainerOptions' => ['class' => 'page-item'],
            'linkOptions' => ['class' => 'page-link'],
            'disabledListItemSubTagOptions' => ['class' => 'page-link'],
            'prevPageLabel' => '&laquo;',
            'nextPageLabel' => '&raquo;',
            'maxButtonCount' => 5,
        ],
        'columns' => [
            'id',
            'name',
            'email',
            'created_at:datetime',

            [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Actions',
            'template' => '<div class="btn-group" role="group">{view} {update} {delete}</div>',
            'buttons' => [
                'view' => function ($url) {
                    return Html::a(
                        '<i class="bi bi-eye"></i> View',
                        $url,
                        ['class' => 'btn btn-sm btn-outline-primary']
                    );
                },
                'update' => function ($url) {
                    return Html::a(
                        '<i class="bi bi-pencil"></i> Edit',
                        $url,
                        ['class' => 'btn btn-sm btn-outline-success']
                    );
                },
                'delete' => function ($url) {
                    return Html::a(
                        '<i class="bi bi-trash"></i> Delete',
                        $url,
                        [
                            'class' => 'btn btn-sm btn-outline-danger',
                            'data-confirm' => 'Are you sure you want to delete this user?',
                            'data-method' => 'post',
                        ]
                    );
                },
            ],
            'urlCreator' => function ($action, $model) {
                return ['/user/user/' . $action, 'id' => $model->id];
            },
        ],
        ],
    ]) ?>


</div>
