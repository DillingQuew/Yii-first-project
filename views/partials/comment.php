<?php if(!empty($comments)):?>
    <?php foreach($comments as $comment):?>
        <div class="bottom-comment dark-wrapper"><!--bottom comment-->

            <div class="comment-img">
                <img width="50" class="img-circle" src="<?= $comment->user->image;?>" alt="">

            </div>

            <div class="comment-text">
                <h5><?=$comment->user->name;?></h5>

                <p class="comment-date">
                    <?= $comment->getDate();?>
                </p>


                <p class="para"><?=$comment->text;?></p>
            </div>
        </div>
    <?php endforeach ?>
<?php endif?>
    <!-- end bottom comment-->

<?php if(!Yii::$app->user->isGuest): ?>
    <div class="leave-comment dark-wrapper"><!--leave comment-->
        <h4>Leave a reply</h4>
        <?php if(Yii::$app->session->getFlash('comment')):?>
            <div class="alert alert-success" role="alert">
                <?= Yii::$app->session->getFlash('comment')?>
            </div>
        <?php endif;?>
        <?php $form = \yii\widgets\ActiveForm::begin([
            'action'=>['site/comment', 'id'=>$article->id],
            'options'=>['class'=>'form-horizontal contact-form',
                'role'=>'form']])?>

        <form class="form-horizontal contact-form" role="form" method="post" action="#">

            <div class="form-group">
                <div class="col-md-12">
                    <?= $form->field($commentForm, 'comment')
                        ->textarea(['class'=>'form-control',
                            'placeholder'=>'Write message'])->label(false); ?>

                </div>
            </div>
            <button type="submit" name="sendComment" class="btn send-btn" onclick="disableButton()">Post Comment</button>
            <?php \yii\widgets\ActiveForm::end();?>
        </form>
    </div><!--end leave comment-->
<?php endif;?>