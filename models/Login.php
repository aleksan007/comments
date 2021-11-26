<?php

namespace app\models;

use DateTime;
use Yii;
use yii\base\Model;


class Login extends Model
{
    public $user;
    public function rules()
    {
        return [
            [['user','text'], 'required'],
            [['user'], 'string', 'max' => 100, 'min'=>3],
        ];
    }

    public function attributeLabels()
    {
        return ['user'=>'Логин'];
    }
}