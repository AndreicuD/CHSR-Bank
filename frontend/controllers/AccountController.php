<?php

namespace frontend\controllers;
use \InvalidArgumentException;

use frontend\models\ContactForm;
use Yii;
use yii\web\Controller;
use common\models\User;
use common\models\Account;

/**
 * Account controller
 */
class AccountController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $user = User::findIdentity(Yii::$app->user->id);
        $model = new Account();
        $model->token_secret = $user->alternative_id;
        $model->user_id = $user->id;
        $model->transferIban = generateRomanianIBAN((string)$model->id);
        $model->account_name = $user->full_name;
        $user->currentIban = $model->transferIban;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model = Account::find()->where('id = :id', [':id' => $model->id])->one();
            Yii::$app->session->setFlash('success', 'The account has been created.');
            return $this->redirect('../user/accounts');
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

}
function generateRomanianIBAN($accountNumber) {
    $bankCode = 'CHSR';

    if (!is_string($accountNumber) && !is_numeric($accountNumber)) {
        throw new InvalidArgumentException("Account number must be a string or numeric.");
    }

    $accountNumber = (string) $accountNumber;
    $accountNumber = str_pad(substr($accountNumber, 0, 16), 16, '0', STR_PAD_LEFT);

    // Construct preliminary IBAN without check digits
    $preliminaryIban = "RO00{$bankCode}1{$accountNumber}";

    $ibanNumeric = '';
    foreach (str_split($preliminaryIban) as $char) {
        if (ctype_alpha($char)) {
            $ibanNumeric .= ord($char) - 55;
        } else {
            $ibanNumeric .= $char;
        }
    }

    $ibanNumeric = substr($ibanNumeric, 4) . substr($ibanNumeric, 0, 4);

    $remainder = intval(substr($ibanNumeric, 0, 1));
    for ($i = 1; $i < strlen($ibanNumeric); $i++) {
        $remainder = ($remainder * 10 + intval($ibanNumeric[$i])) % 97;
    }

    $checkDigits = str_pad((98 - $remainder), 2, '0', STR_PAD_LEFT);

    $iban = "RO{$checkDigits}{$bankCode}1{$accountNumber}";

    return $iban;
}
