<?php

namespace app\controllers;


use app\models\Comments;
use app\models\Response;
use Yii;
use yii\web\Controller;


class CommentController extends Controller
{
    public function actionReply()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = Yii::$app->request->post();

        if($data) {
            $comment = Comments::findOne($data['id_comment']);
            if($comment && $comment->canReply()) {
                $reply = $comment->reply($data['text']);
                if($reply) {
                    return Response::success('Комментарий добавлен');
                }
            }
        }
        return Response::error('Комментарий не добавлен');
    }

    public function actionUpdate()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = Yii::$app->request->post();

        if($data) {
            $comment = Comments::findOne($data['id_comment']);
            if($comment && $comment->canUpdate()) {
                $comment->text = $data['text'];
                if($comment->update()) {
                    return Response::success('Комментарий изменен');
                }
            }
        }
        return Response::error('Комментарий не изменен');
    }


    public function actionNew() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = Yii::$app->request->post();
        if($data) {
            $new = new Comments();
            $new->user = Yii::$app->session->get('username');
            $new->text = $data['text'];
            $new->parent_id = 0;

            if($new->save()) {
                return Response::success('Комментарий добавлен');
            }
        }
        return Response::success('Комментарий не добавлен');
    }

    public function actionDelete() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = Yii::$app->request->post();
        if($data) {
            $comment = Comments::findOne($data['id_comment']);
            if($comment->canDelete() && $comment->delete()) {
                $comment->updateChildrens();
                return Response::success('Комментарий удален');
            }
        }
        return Response::error('Комментарий не удален');
    }


}
