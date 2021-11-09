<?php

use app\models\Comments;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Тестовое Gajin';


?>

<?php Pjax::begin(['id' => 'header_block']); ?>
<?php
$login_user = Yii::$app->session->get('username');


?>
    <div class="row">
        <div class="col-md-6" id="login_div">
            <p><?php echo ($login_user) ? "Залогинен: {$login_user}" : "Никто не залогинен"?></p>
        </div>
    </div>


    <div class="row" id="login-block">
        <div class="col-md-6">
            <?php
            $new = new \app\models\Login();
            $form = ActiveForm::begin(['id'=>'login_form']);
            echo $form->field($new, 'user')->textInput();
            echo Html::submitButton('Залогиниться', ['class' => 'btn btn-success']);
            ActiveForm::end();
            ?>

        </div>
    </div>


    <?php
    $login_user = Yii::$app->session->get('username');
    if($login_user) { ?>
        <div class="row">
            <div class="col-md-6">
                <?php
                $new = new Comments();
                $form = ActiveForm::begin(['id'=>'new_message_form']);
                echo $form->field($new, 'text')->textInput(['maxlength' => true]);
                echo Html::submitButton('Отправить', ['class' => 'btn btn-success']);
                ActiveForm::end();
                ?>
            </div>
        </div>
    <?php } ?>
<?php Pjax::end(); ?>


<div class="site-index">
    <div class="body-content">
        <?php Pjax::begin(['id' => 'all_comments']); ?>
            <div class="row">
                <div class="col-md-12">
                    <?php
                    $comments = Comments::getAll();
                    $trees = Comments::makeTrees($comments);
                    ?>
                </div>
            </div>
        <?php Pjax::end(); ?>
    </div>
</div>


<?php
Modal::begin([
    'id' => 'modal',
    'size' => 'modal-lg',
]); ?>

    <textarea id="comment_input" class="form-control"></textarea><br>
    <button class="btn btn-success" id="saveComment">Отправить</button>

    <div id="status_messages"></div>

<?php  Modal::end();
?>