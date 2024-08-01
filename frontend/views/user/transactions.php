<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var SignupForm $model */

use frontend\models\SignupForm;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = Yii::t('app', 'My Transactions');
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1 class="text-center" class="page_title"><?= Html::encode($this->title) ?></h1>
    <h3 class="page_title">Current IBAN: <b><?= Html::encode($model->currentIban) ?></b></h3>
    
</div>
