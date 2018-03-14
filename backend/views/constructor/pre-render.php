<?php

use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Pré render</h1>

        <p class="lead">Carrege o conteúdo xml.</p>
        <?= Html::a('Continuar.', ['constructor/reader'], ['class' => 'profile-link']) ?>

    </div>

    <div class="body-content">


    </div>
</div>
