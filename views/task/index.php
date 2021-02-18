<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'description:ntext',
            'create_date',
            'is_done',

            ['class' => 'yii\grid\ActionColumn', 'template'=>'{view} {update} {delete} {complete}',
                'buttons'=>[
                    'complete' => function ($url, $model) {
                        return $model->is_done === 0
                            ? Html::a(
                                 '<span class="glyphicon glyphicon-ok"></span>',
                                 $url,
                                 ['title' => Yii::t('yii', 'Mark as complete')]
                            )
                            : false;
                    },
                ],
            ],
        ],
    ]); ?>

</div>
