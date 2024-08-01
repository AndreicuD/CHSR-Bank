<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var SignupForm $model */

use frontend\models\SignupForm;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = Yii::t('app', 'Signup');
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1 class="text-center" class="page_title"><?= Html::encode($this->title) ?></h1>

    <p class="text-center"><?= Yii::t('app', 'Please fill out the following fields to sign-up:') ?></p>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <?php $form = ActiveForm::begin(['id' => 'form-signup', 'layout' => 'floating']); ?>

                <?= $form->field($model, 'firstname')->label(Yii::t('app', 'Firstname')) ?>
                <?= $form->field($model, 'lastname')->label(Yii::t('app', 'Lastname')) ?>
                <?= $form->field($model, 'birth_date', ['inputOptions' => ['type' => 'date']])->label(Yii::t('app', 'Birth date')); ?>
                <!--<?= $form->field($model, 'cnp')->label(Yii::t('app', 'Personal Numeric Number')) ?>-->
                <?= $form->field($model, 'address')->label(Yii::t('app', 'Your address')) ?>
                <?= $form->field($model, 'phone')->textInput()->label(Yii::t('app', 'Phone')); ?>
                <?= $form->field($model, 'email')->label(Yii::t('app', 'Email')) ?>
                <hr>
                <p class="text-center"><?= Yii::t('app', 'Please answer a few security related issues. Not all of them are required.') ?></p>

                <?= $form->field($model, 'income')->checkbox() ?>
                <?= $form->field($model, 'workplace')->label(Yii::t('app', 'Workplace')) ?>
                <?= $form->field($model, 'estIncome')->label(Yii::t('app', 'Estimated income from workplace')) ?>

                <hr>
                <?= $form->field($model, 'password')->passwordInput()->label(Yii::t('app', 'Password')) ?>

                 <hr>

                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
