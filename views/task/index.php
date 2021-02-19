<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <p>
        <?= Html::textInput('search', null, [
            'class' => 'form-control task-search',
            'placeholder' => 'Search by title...'
        ]) ?>
    </p>

    <div id="task-list">
        <?= $this->context->actionList() ?>
    </div>
</div>

<?php
$ajaxUrl = Url::toRoute('list');

$this->registerJs(<<<JS
    $('.task-search').on('keyup', function () {
        let search = $(this).val();

        $.get('$ajaxUrl', {search: search}, function(data) {
            $('#task-list').html(data);
        });
    });
JS
);
?>