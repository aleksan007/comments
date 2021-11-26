<?php

namespace app\controllers;

use app\models\Response;
use app\models\SessionLogin;
use Yii;
use yii\web\Controller;



class SiteController extends Controller
{
    public function actionIndex() {
        return $this->render('index');
    }

    public function actionLogin() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = Yii::$app->request->post('Login');
        $username = $post['user'];

        $session = new SessionLogin();
        $session->login($username);
        return Response::success();
    }
}
