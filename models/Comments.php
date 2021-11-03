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
            [['text'], 'text'],
            [['date'], 'safe'],
            [['parent_id'], 'integer'],

        ];
    }

    public static function getAll() {
        return self::find()->all();
    }

    public static function groupComments($comments) {
        $comments_arr = [];
        foreach ($comments as $comment) {
            $comments_arr[$comment->id] = $comment;
        }
        $res = [];
        foreach($comments as $comment) {
            if ($comment->id == $comment->parent_id) $comment->parent_id = 0;
            $res[$comment->parent_id][] = [$comment->id, $comment->text];
        }
        return $res;
    }

    public static function getTrees($comments) {
        self::makeTree($comments);
    }

    /*public function getDate() {
        return date('d.m.Y H:i',strtotime($this->date));
    }

    public function getAuthor() {
        return $this->user;
    }
    public function getChild() {
        return self::find()->where(['parent_id'=>$this->id])->all();
    }

    public function write() {
        $str = "";
        $str .= "<div class='itemComment'>";
        $str .= "<p>{$this->text}</p>";
        $str .= "<author>{$this->getAuthor()}</author>";
        $str .= "<date>{$this->getDate()}</date>";
        $str .= "<reply>Ответить</reply>";
        $str .= "<reply>Удалить</reply>";

        if ($this->getChild()) {
        }

        $str .= "</div>";

        return $str;
    }*/

    protected static function makeTree($comment, $root = 0) {
        foreach($comment[$root] as $i) {
            echo "<div class='itemComment'>";
            echo "<p>{$i[1]}</p>";
            echo "<date>21.01.2021 17:05</date>";
            if (isset($comment[$i[0]])) self::makeTree($comment, $i[0]);
            echo "</div>";
        }

    }

}