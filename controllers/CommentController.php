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
            $find = Comments::findOne($data['id_comment']);
            if($find) {
                $reply = $find->reply($data['text']);
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
            $find = Comments::findOne($data['id_comment']);
            if($find && $find->canUpdate()) {
                $find->text = $data['text'];
                if($find->update()) {
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
            $find = Comments::findOne($data['id_comment']);

            if($find->canDelete() && $find->delete()) {
                $childrens = Comments::find()->where(['parent_id'=>$find->id])->all();
                foreach ($childrens as $children) {
                    $children->parent_id = $find->parent_id;
                    $children->save();
                }

                return Response::success('Комментарий удален');
            }
        }
        return Response::error('Комментарий не удален');
    }


}
