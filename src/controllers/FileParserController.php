<?php

namespace rmnvl\yii2FileGridView\src\controllers;

use rmnvl\yii2FileGridView\src\parsers\ParserFactory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

class FileParserController extends Controller
{
    public function actionDelete()
    {
        if (!\Yii::$app->request->isPost) {
            throw new NotFoundHttpException();
        }
        $rowId = \Yii::$app->request->post('rowNumber');
        $filePath = \Yii::$app->request->post('filePath');


        $fileParser = ParserFactory::create($filePath);
        $result = $fileParser->deleteRow($rowId);


        \Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }

    public function actionUpdate()
    {
        if (!\Yii::$app->request->isPost) {
            throw new NotFoundHttpException();
        }
        $rowId = \Yii::$app->request->post('rowNumber');
        $filePath = \Yii::$app->request->post('filePath');
        $rowData = \Yii::$app->request->post('rowData');
        if (!file_exists($filePath)) {
            throw new NotFoundHttpException();
        }

        $fileParser = ParserFactory::create($filePath);
        $result = $fileParser->updateRow($rowId, $rowData);

        \Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }

    public function actionGetRowData()
    {
        if (!\Yii::$app->request->isPost) {
            throw new NotFoundHttpException();
        }
        $rowId = \Yii::$app->request->post('rowNumber');
        $filePath = \Yii::$app->request->post('filePath');

        $fileParser = ParserFactory::create($filePath);
        $data = $fileParser->parse();
        if (!isset($data[$rowId])) {
            throw new NotFoundHttpException();
        }
        $row = $data[$rowId];

        \Yii::$app->response->format = Response::FORMAT_JSON;
        return $row;
    }
}