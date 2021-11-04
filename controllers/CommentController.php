<?php

namespace app\controllers;

use app\models\Comments;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class CommentController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    public function actionReply()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = Yii::$app->request->post();

        if($data) {
            $find = Comments::findOne($data['id_comment']);
            if($find) {
                $reply = $find->reply($data['text']);
                if($reply) {
                    return ['status'=>'ok','message'=>'Комментарий добавлен'];
                }
            }
        }
        return ['status'=>'error','message'=>'Комментарий не добавлен'];
    }

    public function actionUpdate()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = Yii::$app->request->post();

        if($data) {
            $find = Comments::findOne($data['id_comment']);
            if($find) {
                $find->text = $data['text'];
                if($find->update()) {
                    return ['status'=>'ok','message'=>'Комментарий изменен'];
                }
            }
        }
        return ['status'=>'error','message'=>'Комментарий не изменен'];
    }


    public function actionNew() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = Yii::$app->request->post();
        if($data) {
            $new = new Comments();
            $new->user = 'new';
            $new->text = $data['text'];
            $new->parent_id = 0;

            if($new->save()) {
                return ['status'=>'ok','message'=>'Комментарий добавлен'];
            }
        }
        return ['status'=>'error','message'=>'Комментарий не добавлен'];
    }

    public function actionDelete() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = Yii::$app->request->post();
        if($data) {
            $find = Comments::findOne($data['id_comment']);

            if($find->delete()) {
                $childrens = Comments::find()->where(['parent_id'=>$find->id])->all();
                foreach ($childrens as $children) {
                    $children->parent_id = $find->parent_id;
                    $children->save();
                }

                return ['status'=>'ok','message'=>'Комментарий удален'];
            }
        }
        return ['status'=>'error','message'=>'Комментарий не удален'];
    }


}
