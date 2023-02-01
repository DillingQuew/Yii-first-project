<?php

namespace app\models;

use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $content
 * @property string|null $date
 * @property string|null $image
 * @property int|null $viewed
 * @property int|null $user_id
 * @property int|null $status
 * @property int|null $category_id
 *
 * @property ArticleTag[] $articleTags
 * @property Comment[] $comments
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title', 'description', 'content'], 'string'],
            [['date'], 'date', 'format'=>'php:Y-m-d'],
            [['date'], 'default', 'value' => date('Y-m-d')],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'content' => 'Content',
            'date' => 'Date',
            'image' => 'Image',
            'viewed' => 'Viewed',
            'user_id' => 'User ID',
            'status' => 'Status',
            'category_id' => 'Category ID',
        ];
    }

    public function saveImage($filename) {
        $this->image = $filename;
        return $this->save();
    }

    public function getImage() {
        return($this->image) ? '/uploads/' . $this->image : '/no-image.png';
    }

    public function deleteImage() {
        $imageUploadModel = new ImageUpload();
        $imageUploadModel->deleteCurrentImage($this->image);
    }

    public function beforeDelete()
    {
        $this->deleteImage();
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }

    public function getCategory() {
//      Где используется этот метод?
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function saveCategory($category_id) {
        $category = Category::findOne($category_id);

        if($category != null) {
            $this->link('category', $category);
            return true;
        }
    }

    public function getTags() {
        return $this->hasMany(Tag::class, ['id'=>'tag_id'])
            ->viaTable('article_tag', ['article_id'=>'id']);
    }

    public function getSelectedTags() {
       $selectedIds = $this->getTags()->select('id')->asArray()->all();
       return ArrayHelper::getColumn($selectedIds, 'id');
    }

    public function articleTags() {
        $tagsObj = $this->getTags()->select('id')->asArray()->all();

        $tags = Tag::find()
            ->where(['id' => $tagsObj])
            ->all();

//        var_dump(ArrayHelper::getColumn($tags, 'id')); die;
//        var_dump($customer); die;

//        return ArrayHelper::getColumn($tags, 'id');
          return $tags;
    }


    public function saveTags($tags) {
        if (is_array($tags)) {
            $this->clearCurrentTags();
            foreach($tags as $tag_id) {
                $tag = Tag::findOne($tag_id);
                $this->link('tags', $tag);
            }
        }
    }
    public function clearCurrentTags(){
        ArticleTag::deleteAll(['article_id' => $this->id]);
    }

    public function getDate() {
        return Yii::$app->formatter->asDate($this->date);
    }

    public static function getAll($pageSize = 6) {
        $query = Article::find();
        $countQuery = clone $query;
        $pagination = new Pagination(['totalCount' => $countQuery->count(), 'pageSize'=>$pageSize]);
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $data['articles'] = $articles;
        $data['pagination'] = $pagination;

        return $data;
    }
    public static function getPopular() {
        return Article::find()->orderBy('viewed desc')->limit(3)->all();
    }
    public static function getRecent() {
        return Article::find()->orderBy('date asc')->limit(4)->all();
    }

    public function saveArticle() {
        $this->user_id = Yii::$app->user->id;
        return $this->save();
    }
}
