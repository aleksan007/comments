<?php

namespace app\models;

class TreeBuilder
{
    protected $comments;
    protected $grouped_comments;

    public function __construct($comments)
    {
        $this->comments = $comments;
        $this->grouped_comments = $this->groupComments();
    }

    protected function groupComments() {
        $comments_arr = [];
        foreach ($this->comments as $comment) {
            $comments_arr[$comment->id] = $comment;
        }
        $res = [];
        foreach($comments_arr as $comment) {
            if ($comment->id == $comment->parent_id) $comment->parent_id = 0;
            $res[$comment->parent_id][] = $comment;
        }
        return $res;
    }

    protected function writeComment($comments, $comment) {
        echo "<div class='comment'>";
        echo "<text>{$comment->text}</text>";
        echo "<author>{$comment->getAuthor()}</author> ";
        echo "<date>{$comment->getDate()}</date> ";

        if($comment->canDelete())  echo "<delete attr_id_comment={$comment->id}>Удалить</delete>";
        if($comment->canUpdate())  echo "<change attr_id_comment={$comment->id}>Изменить</change>";
        if($comment->canReply())  echo  "<reply attr_id_comment={$comment->id}>Ответить</reply>";

        if (isset($comments[$comment->id])) {
            $this->buildTrees($comments, $comment->id);
        }
        echo "</div>";
    }

    public function buildTrees($comments = null, $root = 0) {
        if (!$comments) {
            $comments = $this->grouped_comments;
            if(!$comments) return false;
        }

        foreach($comments[$root] as $comment) {
            self::writeComment($comments, $comment);
        }
    }


}