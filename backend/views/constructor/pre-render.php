<?php

use yii\helpers\Html;
  use yii\widgets\ActiveForm;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Pré render</h1>

        <p class="lead">Carrege o conteúdo xml.</p>
        <?php

        $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'file')->fileInput() ?>

        <button>Submit</button>

        <?php ActiveForm::end(); ?>

    </div>

    <div class="body-content">


    </div>
</div>
