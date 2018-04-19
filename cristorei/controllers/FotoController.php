<?php

namespace app\controllers;

use yii\imagine\Image;
use yii\web\Controller;

class FotoController extends Controller
{
    public function actionRotacionar($foto, $angulo = 90)
    {
        Image::getImagine()->open($foto)->rotate($angulo)->save($foto);
        $this->redirect(\Yii::$app->request->referrer);
    }

}