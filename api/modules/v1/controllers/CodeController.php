<?php

namespace api\modules\v1\controllers;

use common\models\Code;
use Yii;
use yii\helpers\ArrayHelper;

class CodeController extends AppController
{
    public function actionRegister(): array
    {
        $userId = Yii::$app->user->id;
        $code = Yii::$app->request->post('code');

        if (!$code) {
            return $this->returnError('Code is required.');
        }

        $codeModel = Code::findOne(['public_status' => 0, 'code' => $code]);

        $codeModel->user_id = $userId;
        $codeModel->taken_at = time();
        $codeModel->user_ip = Yii::$app->request->longUserIp;
        $codeModel->public_status = 1;
        $codeModel->save();

        return $this->returnSuccess([
            'promocode' => $codeModel->promocode
        ]);
    }
}
