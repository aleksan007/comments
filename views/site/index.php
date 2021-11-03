<?php

use app\models\Comments;

$this->title = 'Тестовое Gajin';
?>

<div class="site-index">

    <div class="body-content">
        <div class="row">

            <?php
            $comments = Comments::getAll();
            $grouped = Comments::groupComments($comments);
            $trees = Comments::getTrees($comments);
            ?>




        </div>

    </div>
</div>


<?php



?>