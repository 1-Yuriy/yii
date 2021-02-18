<?php

namespace app\controllers;

use DateTime;
use Exception;
use Yii;
use app\models\Task;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Task::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Task model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     * @throws Exception
     */
    public function actionCreate()
    {
        $model = new Task();

        if ($model->load(Yii::$app->request->post())) {
            $model->create_date = (new DateTime())->format('Y-m-d H:i:s');

            if ($model->save()) {
                $this->sendNotification('New task created', 'title: ' . $model->title);

                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                throw new Exception('Can\'t save item');
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $task = $this->findModel($id);
        $this->sendNotification('Task #' . $task->id . ' deleted', 'title: ' . $task->title);
        $task->delete();

        return $this->redirect(['index']);
    }

    /**
     * Marked task as completed
     * @param $id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionComplete($id)
    {
        $task = $this->findModel($id);
        $task->is_done = 1;
        $task->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Send notification to company
     * @param $subject
     * @param $message
     * @param string $provider - email|sms
     * @throws Exception
     */
    protected function sendNotification($subject, $message, $provider = 'email')
    {
        switch ($provider) {
            case 'email':
                $this->sendToEmail($subject, $message);
                break;
            case 'sms':
                $this->sendToSms($message);
                break;
            default:
                break;
        }
    }

    /**
     * TODO: этой функции здесь не место, при рефакторинге должна быть перемещена
     * @param $subject
     * @param $message
     */
    private function sendToEmail($subject, $message)
    {
        Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['senderEmail'])
            ->setTo(Yii::$app->params['companyEmail'])
            ->setSubject($subject)
            ->setTextBody($message)
            ->send();
    }

    /**
     * TODO: этой функции здесь не место, при рефакторинге должна быть перемещена
     * @param $message
     * @throws Exception
     */
    private function sendToSms($message)
    {
        // Yii::$app->params['phoneForSms']; // TODO: номер для отправки смс

        throw new Exception('This feature is not yet implemented');
    }
}
