<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Home Page';
?>
<div class="site-index">
    <div class="body-content">
    <?= Html::a('To task list', Url::toRoute(['task/index'])) ?>
    </div>
</div>
