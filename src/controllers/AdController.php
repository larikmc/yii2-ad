<?php

declare(strict_types=1);

namespace larikmc\ad\controllers;

use larikmc\ad\models\Ad;
use larikmc\ad\models\AdPosition;
use larikmc\ad\models\AdSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * AdController implements the CRUD actions for Ad model.
 */
class AdController extends Controller
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
     * Lists all Ad models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new AdSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $data = [
            'position' => AdPosition::getListCached(),
            'partner' => Ad::partnerList(),
        ];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'data' => $data,
        ]);
    }

    /**
     * Displays a single Ad model.
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
     * Creates a new Ad model.
     * @return Response|string
     */
    public function actionCreate()
    {
        $model = new Ad();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Рекламный блок успешно создан.');
                return $this->redirect(['index']);
            }

            Yii::$app->session->setFlash('error', 'Ошибка при сохранении: ' . json_encode($model->errors, JSON_UNESCAPED_UNICODE));
        }

        $data = [
            'partner' => Ad::partnerList(),
            'position' => AdPosition::getListCached(),
        ];

        return $this->render('create', [
            'model' => $model,
            'data' => $data,
        ]);
    }

    /**
     * Updates an existing Ad model.
     * @param int $id
     * @return Response|string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Рекламный блок успешно обновлен.');
                return $this->redirect(['index']);
            }

            Yii::$app->session->setFlash('error', 'Ошибка при обновлении: ' . json_encode($model->errors, JSON_UNESCAPED_UNICODE));
        }

        $data = [
            'partner' => Ad::partnerList(),
            'position' => AdPosition::getListCached(),
        ];

        return $this->render('update', [
            'model' => $model,
            'data' => $data,
        ]);
    }

    /**
     * Deletes an existing Ad model.
     * @param int $id
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete(int $id): Response
    {
        try {
            $this->findModel($id)->delete();
            Yii::$app->session->setFlash('success', 'Рекламный блок удален.');
        } catch (\Throwable $e) {
            Yii::$app->session->setFlash('error', 'Ошибка при удалении: ' . $e->getMessage());
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Ad model based on its primary key value.
     * @param int $id
     * @return Ad
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Ad
    {
        if (($model = Ad::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошенная страница не существует.');
    }
}
