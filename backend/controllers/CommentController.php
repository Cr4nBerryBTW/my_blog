<?php

namespace backend\controllers;

use common\models\Comment;
use common\models\CommentSearch;
use yii\db\StaleObjectException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * CommentController implements the CRUD actions for Comment model.
 */
class CommentController extends Controller
{

    /**
     * Lists all Comment models.
     * @return string
     */
    public function actionIndex(): string
    {
        $comments = Comment::find()->orderBy('id desc')->all();

        return $this->render('index', [ 'comments' => $comments]);
    }

    /**
     * @throws StaleObjectException
     * @throws \Throwable
     */
    public function actionDelete($id)
    {
        $comment = Comment::findOne($id);
        if ($comment->delete())
        {
            return $this->redirect(['comment/index']);
        }
    }

    public function actionAllow($id)
    {
        $comment = Comment::findOne($id);
        if ($comment->allow())
        {
            return $this->redirect(['comment/index']);
        }
    }

    public function actionDisallow($id)
    {
        $comment = Comment::findOne($id);
        if ($comment->disallow())
        {
            return $this->redirect(['comment/index']);
        }
    }
}
