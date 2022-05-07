<?php

use humhub\widgets\SiteLogo;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->pageTitle = Yii::t('UserModule.auth', 'Create Account');
?>

<div class="container" style="text-align: center;">
    <?= SiteLogo::widget(['place' => 'login']) ?>
    <br>
    <h1 id="app-title" class="animated fadeIn">
        <?= Html::encode(Yii::$app->name) ?>
    </h1>
    <br/>
    <div class="row">
        <div id="create-account-form" class="panel panel-default animated bounceIn"
             style="max-width: 500px; margin: 0 auto 20px; text-align: left;">
            <div class="panel-heading">
                <?= Yii::t('UserModule.auth', '<strong>Account</strong> registration') ?>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin(['id' => 'registration-form', 'enableClientValidation' => false]); ?>
                <?= $hForm->render($form); ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<script <?= \humhub\libs\Html::nonce() ?>>
    $(function () {
        // set cursor to login field
        $('#User_username').focus();

        // set user time zone val
        $('#user-time_zone').val(Intl.DateTimeFormat().resolvedOptions().timeZone);
    })

    // Shake panel after wrong validation
    <?php foreach ($hForm->models as $model) : ?>
    <?php if ($model->hasErrors()) : ?>
    $('#create-account-form').removeClass('bounceIn');
    $('#create-account-form').addClass('shake');
    $('#app-title').removeClass('fadeIn');
    <?php endif; ?>
    <?php endforeach; ?>

</script>
