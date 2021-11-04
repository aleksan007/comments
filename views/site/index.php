<?php

use app\models\Comments;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Тестовое Gajin';

?>


<div class="row">
    <div class="col-md-6">

    </div>
</div>



<div class="site-index">
    <div class="body-content">

        <div class="row">
            <div class="col-md-12">
                <?php $form = ActiveForm::begin(['id'=>'new_message_form']); ?>
                    <?= $form->field($new, 'text')->textInput(['maxlength' => true])  ?>
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']); ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>

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

        <div class="row">
            <?php
            Modal::begin([
                'id' => 'modal',
                'size' => 'modal-lg',
            ]); ?>

            <div id='modalContent'>
                <input type="text" id="comment_input" class="form-control">
                <button class="btn btn-success" id="saveComment">Сохранить</button>
                <div id="status_messages"></div>
            </div>

            <?php  Modal::end();
            ?>
        </div>
    </div>
</div>


<?php



?>