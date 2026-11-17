<?php

declare(strict_types=1);

namespace larikmc\ad\controllers;

use larikmc\ad\models\AdPosition;
use larikmc\ad\models\AdPositionSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * AdPositionController implements the CRUD actions for AdPosition model.
 */
class AdPositionController extends Controller
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
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all AdPosition models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new AdPositionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'data' => [
                'category' => AdPosition::categoryList(),
            ],
        ]);
    }

    /**
     * Displays a single AdPosition model.
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AdPosition model.
     * @return Response|string
     */
    public function actionCreate()
    {
        $model = new AdPosition();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Позиция создана.');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'data' => [
                'category' => AdPosition::categoryList(),
            ],
        ]);
    }

    /**
     * Updates an existing AdPosition model.
     * @param int $id
     * @return Response|string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Позиция обновлена.');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'data' => [
                'category' => AdPosition::categoryList(),
            ],
        ]);
    }

    /**
     * Deletes an existing AdPosition model.
     * @param int $id
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete(int $id): Response
    {
        try {
            $this->findModel($id)->delete();
            Yii::$app->session->setFlash('success', 'Позиция удалена.');
        } catch (\Throwable $e) {
            Yii::$app->session->setFlash('error', 'Ошибка при удалении: ' . $e->getMessage());
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the AdPosition model based on its primary key value.
     * @param int $id
     * @return AdPosition
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): AdPosition
    {
        if (($model = AdPosition::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошенная страница не существует.');
    }
}
