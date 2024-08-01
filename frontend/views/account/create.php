<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var SignupForm $model */

use frontend\models\SignupForm;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = Yii::t('app', 'Create Account');
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1 class="text-center" class="page_title"><?= Html::encode($this->title) ?></h1>

    <p class="text-center"><?= Yii::t('app', 'Please fill out the following fields to make this account:') ?></p>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <?php $form = ActiveForm::begin(['id' => 'form-createaccount', 'layout' => 'floating']); ?>

                <?= $form->field($model, 'account_name')->label(Yii::t('app', 'Account Name')) ?>

                <hr>

                <div class="form-group">
                    <?= Html::submitButton('Create Account', ['class' => 'btn btn-primary', 'name' => 'createaccount-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
