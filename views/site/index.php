<?php

/** @var yii\web\View $this */

use app\widgets\Sidebar;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'My Yii Application';
?>
<!--main content start-->
<div class="main-content main-content__dark">
    <div class="container">
        <div class="row">
            <div class="col-md-8">

                <?php foreach($articles as $article):?>
                    <article class="post dark-wrapper">
                        <div class="post-thumb">
                            <a href="<?= Url::toRoute(['site/view', 'id'=>$article->id]); ?>"><img src="<?= $article->getImage(); ?>" alt=""></a>

                            <a href="<?= Url::toRoute(['site/view', 'id'=>$article->id]); ?>" class="post-thumb-overlay text-center">
                                <div class="text-uppercase text-center">View Post</div>
                            </a>
                        </div>
                        <div class="post-content">
                            <header class="entry-header text-center text-uppercase">

                                <h6><a href="<?= Url::toRoute(['site/category', 'id'=>$article->category->id]); ?>"><?= $article->category->title; ?></a></h6>

                                <h1 class="entry-title entry-title__dark-link"><a href="<?= Url::toRoute(['site/view', 'id'=>$article->id]); ?>"><?= $article->title ?> </a></h1>


                            </header>
                            <div class="entry-content entry-content__dark">
                                <p>
                                    <?= $article->description?>
                                </p>

                                <div class="btn-continue-reading text-center text-uppercase">
                                    <a href="<?= Url::toRoute(['site/view', 'id'=>$article->id]); ?>" class="more-link more-link__dark">Continue Reading</a>
                                </div>
                            </div>
                            <div class="social-share social-share__dark">
                                <span class="social-share-title pull-left text-capitalize">By <?=$article->author->name?> On <?= $article->getDate();?></span>
                                <ul class="text-center pull-right">
                                    <li><a class="s-facebook" href="#"><i class="fa fa-eye"></i></a></li><?= (int)$article->viewed?>
                                </ul>
                            </div>
                        </div>
                    </article>
                <?php endforeach;?>

              <?php
              echo LinkPager::widget([
                  'pagination' => $pagination,
              ]);
              ?>
            </div>
            <div class="col-md-4" data-sticky_column>
                <?= Sidebar::widget() ?>
            </div>
        </div>
    </div>
</div>
<!-- end main content-->
