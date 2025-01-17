<?php

namespace frontend\controllers;

use common\models\ChimeLike;
use common\models\User;
use Yii;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\Chime;
use yii\web\Response;

/**
 * Chime controller
 */
class ChimeController extends Controller
{
    /**
     * {@inheritdoc}
     */
    /*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['listen'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }*/

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {            
        if ($action->id == 'update') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionIndex($instrument = null)
    {
        $searchModel = new Chime();
        $filters = [];
        $filters['Chime']['instrument'] = $instrument;
        $dataProvider = $searchModel->search($filters);
        $dataProvider->pagination->pageParam = 'p';
        $dataProvider->query->andWhere(['public' => 1, 'active' => 1]);
        $dataProvider->pagination->forcePageParam = 0;
        $dataProvider->pagination->defaultPageSize = 18;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Add a chime
     * @return string|Response
     */
    public function actionCreate(): string|Response
    {
        $model = new Chime();
        $model->user_id = Yii::$app->user->id;
        $model->instrument = 'piano';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model = Chime::find()->where('id = :id', [':id' => $model->id])->one();
            Yii::$app->session->setFlash('success', 'The chime has been created.');
            return $this->redirect(['chime/listen', 'id' => $model->public_id]);
        }

        return $this->render('create' ,[
            'model' => $model,
        ]);
    }

    /**
     * update chime.
     * @param string $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id): Response|string
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'The chime has been updated.');
            $this->redirect(['user/transactions']);
        } else {
            Yii::$app->session->setFlash('error', 'There was an error saving the chime.');
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * delete a chime.
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->delete()) {
            ChimeLike::deleteAll(['chime_id' => $model->id]);
            Yii::$app->session->setFlash('success', 'The chime has been deleted.');
        }

        $this->redirect(['user/transactions']);
    }

    /**
     * Finds the Chime based on its public_id value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id - the public_id of the model
     * @return array|Chime|ActiveRecord
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(string $id): array|Chime|ActiveRecord
    {
        if (($model = Chime::find()->where('public_id = :id', [':id' => $id])->andWhere(['user_id' => Yii::$app->user->id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested chime does not exist.'));
    }

        /**
     * Finds the Chime based on its public_id value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id - the public_id of the model
     * @return array|Chime|ActiveRecord
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelPublic(string $id): array|Chime|ActiveRecord
    {
        if (($model = Chime::find()->where('public_id = :id', [':id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested chime does not exist.'));
    }
}
