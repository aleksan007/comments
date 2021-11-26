<?php

namespace app\models;

use Yii;


class SessionLogin implements LoginInterface
{

    public function login($username) {
        return Yii::$app->session->set('username',$username);
    }

    public static function getLogedUsername() {
        return Yii::$app->session->get('username');
    }

    public static function isLogin($username) {
        return $username == Yii::$app->session->get('username');
    }


}