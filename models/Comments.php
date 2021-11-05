<?php

namespace app\models;

use Yii;


class Comments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text', 'user'], 'required'],
            [['user'], 'string', 'max' => 100],
            [['text'], 'string'],
            [['date'], 'safe'],
            [['parent_id'], 'integer'],

        ];
    }

    public function attributeLabels()
    {
        return ['text'=>'Новое сообщение'];
    }

    public static function getAll() {
        $all = self::find()->all();
        return self::groupComments($all);
    }

    public static function groupComments($comments) {
        $comments_arr = [];
        foreach ($comments as $comment) {
            $comments_arr[$comment->id] = $comment;
        }
        $res = [];
        foreach($comments_arr as $comment) {
            if ($comment->id == $comment->parent_id) $comment->parent_id = 0;
            $res[$comment->parent_id][] = $comment;
        }
        return $res;
    }

    public function getDate() {
        return date('d.m.Y H:i',strtotime($this->date));
    }

    public function getAuthor() {
        return $this->user;
    }

    public static function makeTrees($comments, $root = 0) {
        if($root !== 0) {
           // print_r(count($comments));
            //print_r($root);
        }
        print_r($root);
        if(!$comments) return false;
        foreach($comments[$root] as $comment) {
            echo "<div class='comment'>";
            echo "<text>{$comment->text}</text>";
            echo "<author>{$comment->getAuthor()}</author> ";
            echo "<date>{$comment->getDate()}</date> ";

            if($comment->canDelete())  echo "<delete attr_id_comment={$comment->id}>Удалить</delete> ";
            if($comment->canUpdate())  echo "<change attr_id_comment={$comment->id}>Изменить</change> ";
            echo "<reply attr_id_comment={$comment->id}>Ответить</reply> ";


            if (isset($comments[$comment->id])) {
                self::makeTrees($comments, $comment->id);
            }
            echo "</div>";

        }
    }

    public function reply($text) {
        $new = new Comments();
        $new->text = $text;
        $new->user = Yii::$app->session->get('username');
        $new->parent_id = $this->id;
       return $new->save();
    }

    protected function getHourDiff() {
        return abs(round((strtotime(date($this->date)) - strtotime(date('YmdHis')))/3600, 1));
    }

    public function canDelete($hour = 1) {
        return ($this->getHourDiff() >= $hour ? false : true) && Yii::$app->session->get('username') == $this->user;
    }

    public function canUpdate($hour = 1) {
        return ($this->getHourDiff() >= $hour ? false : true) && Yii::$app->session->get('username') == $this->user;
    }

}