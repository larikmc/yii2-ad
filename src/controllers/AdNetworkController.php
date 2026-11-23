<?php

declare(strict_types=1);

namespace larikmc\ad\controllers;

use larikmc\ad\models\AdNetwork;
use larikmc\ad\models\AdNetworkSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * AdNetworkController manages head scripts and advertising network integrations.
 */
class AdNetworkController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                        'toggle' => ['POST', 'GET'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all AdNetwork models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new AdNetworkSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Toggles network active status
     *
     * @param int $id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionToggle(int $id): Response
    {
        $model = $this->findModel($id);
        $newStatus = $model->toggleStatus();

        if ($this->request->isAjax) {
            return $this->asJson([
                'success' => true,
                'status' => $newStatus,
                'message' => "Сеть {$model->name} " . ($newStatus ? 'включена' : 'отключена'),
            ]);
        }

        Yii::$app->session->setFlash(
            'success',
            "Сеть «{$model->name}» успешно " . ($newStatus ? 'включена в <head>' : 'отключена из <head>')
        );

        return $this->redirect($this->request->referrer ?: ['index']);
    }

    /**
     * Updates an existing AdNetwork model.
     *
     * @param int $id
     * @return Response|string
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Настройки сети «{$model->name}» сохранены.");
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new AdNetwork model.
     *
     * @return Response|string
     */
    public function actionCreate()
    {
        $model = new AdNetwork();
        $model->status = 1;
        $model->sort_order = 50;

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Рекламная сеть «{$model->name}» добавлена.");
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AdNetwork model.
     *
     * @param int $id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionDelete(int $id): Response
    {
        $model = $this->findModel($id);
        $name = $model->name;
        $model->delete();

        Yii::$app->session->setFlash('success', "Сеть «{$name}» удалена.");
        return $this->redirect(['index']);
    }

    /**
     * Finds the AdNetwork model based on its primary key value.
     *
     * @param int $id
     * @return AdNetwork
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): AdNetwork
    {
        if (($model = AdNetwork::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Рекламная сеть не найдена.');
    }
}
