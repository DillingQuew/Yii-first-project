<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Article $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="article-form">
<?php     $data = $model->getArticleCategories($model);?>
<?php //    $data = $model->getCategory();?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6, 'class'=>'ckeditor']) ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'status')->checkbox() ?>

    <?= $form->field($model,'category')->dropDownList($data['categories']) ?>
<!--    --><?php //= var_dump($data['categories']);?>






    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
