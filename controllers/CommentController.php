<?php

namespace app\controllers;


use app\models\Comments;
use app\models\Response;
use app\models\SessionLogin;
use Yii;
use yii\web\Controller;


class CommentController extends Controller
{

    public function beforeAction($action)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    public function actionReply()
    {
        $data = Yii::$app->request->post();
        if($data) {
            $comment = Comments::findOne($data['id_comment']);
            return $comment->reply($comment['text']);
        }
        return Response::error('Комментарий не добавлен');
    }

    public function actionUpdate()
    {
        $data = Yii::$app->request->post();
        if($data) {
            $comment = Comments::findOne($data['id_comment']);
            return $comment->edit($data['text']);
        }
        return Response::error('Комментарий не изменен');
    }


    public function actionNew() {
        $data = Yii::$app->request->post();
        if($data) {
            return Comments::createNew($data['text']);
        }
        return Response::success('Комментарий не добавлен');
    }

    public function actionDelete() {
        $data = Yii::$app->request->post();
        if($data) {
            $comment = Comments::findOne($data['id_comment']);
            return $comment->deleteComment();
        }
        return Response::error('Комментарий не удален');
    }


}
