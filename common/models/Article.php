<?php

namespace common\models;

use common\models\query\ArticleQuery;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
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
class Article extends ActiveRecord
{
    /**
     * @var mixed|null
     */
    private $category;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title'], 'required'],
            [['title','description', 'content'], 'string'],
            [['date'], 'date','format' =>'php:Y-m-d'],
            [['date'], 'default', 'value' => date('Y-m-d')],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
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

    /**
     * Gets query for [[ArticleTags]].
     *
     * @return ActiveQuery
     */
    public function getArticleTags(): ActiveQuery
    {
        return $this->hasMany(ArticleTag::class, ['article_id' => 'id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return ActiveQuery
     */
    public function getComments(): ActiveQuery
    {
        return $this->hasMany(Comment::class, ['article_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ArticleQuery the active query used by this AR class.
     */
    public static function find(): ArticleQuery
    {
        return new ArticleQuery(get_called_class());
    }

    public function saveImage($filename): bool
    {
        $this->image = $filename;

        return $this->save(false);
    }

    public function getImage(): string
    {
        return ($this->image) ? '/uploads/' . $this->image : '/no-image.jpg';
    }

    public function deleteImage()
    {
        $imageUploadModel = new ImageUpload();
        $imageUploadModel->deleteCurrentImage($this->image);
    }

    public function beforeDelete(): bool
    {
        $this->deleteImage();
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class,['id' => 'category_id']);
    }

    /**
     * @throws InvalidConfigException
     */
    public function getTags(): ActiveQuery
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->
        viaTable('article_tag', ['article_id' => 'id']);
    }

    /**
     * @throws InvalidConfigException
     */
    public function getSelectedTags(): array
    {
        $selectedTags = $this->getTags()->select('id')->asArray()->all();
        return ArrayHelper::getColumn($selectedTags, 'id');
    }

    public function saveCategory($category_id)
    {
        $category = Category::findOne($category_id);
        if ($category != null){
            $this->link('category', $category);
            return true;
        }
    }

    public function saveTags($tags)
    {
        if (is_array($tags)){
           $this->clearCurrentTags();
           foreach ($tags as $tag_id)
           {
               $tag = Tag::findOne($tag_id);
                if (isset($tag)) {
                    $this->link('tags', $tag);
                }
           }
        }
    }

    public function clearCurrentTags()
    {
        ArticleTag::deleteAll(['article_id' => $this->id]);
    }
}
