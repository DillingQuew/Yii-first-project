<?php
namespace app\widgets;
use app\models\Article;
use app\models\Category;
use yii\base\Widget;
use yii\helpers\Html;

class Sidebar extends Widget
{
//    public $popular;
//    public $recent;
//    public $categories;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $popular = Article::getPopular();
        $recent = Article::getRecent();
        $categories = Category::getAll();
        return $this->render('@app/views/widgets/sidebar', [
            'popular'=>$popular,
            'recent'=>$recent,
            'categories'=>$categories
        ]);
    }
}