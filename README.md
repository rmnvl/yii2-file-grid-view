Установка:
 добавить в composer.json в блок require:

    "rmnvl/yii2-file-grid-view": "dev-master"

 в блок repositories:

    {
        "type": "git",
        "url": "https://github.com/rmnvl/yii2-file-grid-view.git"
    }

запустить команду:

    composer require rmnvl/yii2-file-grid-view:dev-master

В файл конигурации, добавить 

    'controllerMap' => [
        'file-parser' => 'rmnvl\yii2FileGridView\src\controllers\FileParserController'
    ],


Пример использования. Передайте путь к файлу в виджет:

    <?= \rmnvl\yii2FileGridView\src\models\FileGridView::widget([
        'filePath' => $filePath,
        'sort' => [
            'attributes' => [
                'src',
                'parent',
                'title'
            ]
        ],
        'columns' => [
            'parent',
            'title',
            'address',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ]
        ]
    ]); ?>
