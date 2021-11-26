<?php

namespace app\models;

use Yii;


class Comments extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'comments';
    }


    public function rules()
    {
        return [
            [['user'], 'required'],
            [['user'], 'string', 'max' => 100],
            [['text'], 'string'],
            [['date'], 'safe'],
            [['parent_id'], 'integer'],

        ];
    }

    public $login_repository;


    public function attributeLabels()
    {
        return ['text'=>'Новое сообщение'];
    }

    public static function getAll() {
        return self::find()->all();
    }


    public function getDate() {
        return date('d.m.Y H:i',strtotime($this->date));
    }

    public function getAuthor() {
        return $this->user;
    }

    public function reply($text) {
        if($this->canReply()) {
            $new = new self();
            $new->text = $text;
            $new->user = SessionLogin::getLogedUsername();
            $new->parent_id = $this->id;
            if($new->save()) {
                return Response::success('Комментарий добавлен');
            }
        }
    }

    public static function createNew($text) {
        $new = new self();
        $new->user = SessionLogin::getLogedUsername();
        $new->text = $text;
        $new->parent_id = 0;
        if($new->save()) {
            return Response::success('Комментарий добавлен');
        }
    }

    protected function getHourDiff() {
        return abs(round((strtotime(date($this->date)) - strtotime(date('YmdHis')))/3600, 1));
    }

    public function canDelete($hour = 1) {
        return ($this->getHourDiff() >= $hour ? false : true) && $this->isAuthor();
    }

    public function canUpdate($hour = 1) {
        return ($this->getHourDiff() >= $hour ? false : true) && $this->isAuthor();
    }

    public function canReply() {
        return (SessionLogin::getLogedUsername()) ? true : false;
    }

    protected function isAuthor() {
        return SessionLogin::isLogin($this->user) == $this->user;
    }

    public function updateChildrens() {
        $childrens = self::find()->where(['parent_id'=>$this->id])->all();
        foreach ($childrens as $children) {
            $children->parent_id = $this->parent_id;
            $children->save();
        }
    }

    public function deleteComment() {
        if($this->canDelete() && $this->delete()) {
            $this->updateChildrens();
            return Response::success('Комментарий удален');
        }
    }

    public function edit($text) {
        if($this->canUpdate()) {
            $this->text = $text;
            if($this->update()) {
                return Response::success('Комментарий изменен');
            }
        }
    }







}