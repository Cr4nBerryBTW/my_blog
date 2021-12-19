<?php


use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?php if (!empty($comments)):?>
        <table class="table">
            <thead>
                <td>#</td>
                <td> Article title </td>
                <td> Author </td>
                <td> Text </td>
                <td> Action </td>
            </thead>
            <tbody>
                <?php foreach ($comments as $comment):?>
                    <tr>
                        <td><?= $comment->id?></td>
                        <td><?= $comment->article->title ?> </td>
                        <td><?= $comment->user->username?></td>
                        <td><?= $comment->text?></td>
                        <td>
                            <?php if (!$comment->isAllowed()):?>
                                <a class="btn btn-success" href="<?= Url::toRoute(['comment/allow', 'id'=>$comment->id]);?>">Allow</a>
                            <?php else:?>
                                <a class="btn btn-warning" href="<?= Url::toRoute(['comment/disallow', 'id'=>$comment->id]);?>">Disallow</a>
                            <?php endif;?>
                            <a class="btn btn-danger" href="<?= Url::toRoute(['comment/delete', 'id'=>$comment->id]);?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>


</div>
