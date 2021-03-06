<?php

namespace common\models;


use common\models\query\CommentQuery;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property string|null $text
 * @property int|null $user_id
 * @property int|null $article_id
 * @property int|null $status
 * @property string|null $date
 *
 * @property Article $article
 * @property User $user
 */
class Comment extends ActiveRecord
{
    /**
     * @var mixed|null
     */

    /**
     * {@inheritdoc}
     */
    const STATUS_ALLOW = 1;
    const STATUS_DISALLOW = 0;

    public static function tableName(): string
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id', 'article_id', 'status'], 'integer'],
            [['text'], 'string', 'max' => 255],
            [['date'], 'date', 'format' =>'php:Y-m-d'],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Article::class, 'targetAttribute' => ['article_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'user_id' => 'User ID',
            'article_id' => 'Article ID',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Article]].
     *
     * @return ActiveQuery
     */
    public function getArticle(): ActiveQuery
    {
        return $this->hasOne(Article::class, ['id' => 'article_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return CommentQuery the active query used by this AR class.
     */
    public static function find(): CommentQuery
    {
        return new CommentQuery(get_called_class());
    }

    /**
     * @throws InvalidConfigException
     */
    public function getDate(): string
    {
        return Yii::$app->formatter->asDate($this->date);
    }

    public function isAllowed(): ?int
    {
        return $this->status;
    }

    public function allow(): bool
    {
        $this->status = self::STATUS_ALLOW;
        return $this->save(false);
    }

    public function disallow(): bool
    {
        $this->status = self::STATUS_DISALLOW;
        return $this->save(false);
    }
}
