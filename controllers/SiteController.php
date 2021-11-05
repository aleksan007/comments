<?php

namespace app\controllers;

use app\models\Response;
use Yii;
use yii\web\Controller;



class SiteController extends Controller
{
    public function actionIndex() {
        return $this->render('index');
    }

    public function actionLogin() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->session->set('username',Yii::$app->request->post('username'));
        return Response::success(Yii::$app->session->get('username'));
    }
}
