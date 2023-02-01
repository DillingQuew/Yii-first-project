<?php

namespace app\controllers;
use app\models\LoginForm;
use app\models\SingupForm;
use app\models\User;
use Yii;
use yii\web\Controller;
use yii\web\IdentityInterface;
use yii\web\Response;

class AuthController extends Controller {
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('/auth/login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionTest() {
        $user = User::findOne(1);
        Yii::$app->user->logout();
//        Yii::$app->user->login($user);
       echo (Yii::$app->user->isGuest)  ? 'Пользователь не авторизирован' : "Админ";
    }

    public function actionLoginVk($uid, $first_name, $photo) {
        $user = new User();
        if($user->saveFromVk($uid, $first_name, $photo)) {
            return $this->redirect(['site/index']);
        }
    }

    public function actionSingup() {
        $model = new SingupForm();

        if(Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            if($model->signup()) {
                return $this->redirect(['auth/login']);
            }
        }

        return $this->render('singup', ['model'=>$model]);
    }

}