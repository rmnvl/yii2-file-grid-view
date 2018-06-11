Для установки компонента добавить в composer.json в блок require:

    "rmvl/yii2-file-grid-view": "dev-master"

в блок repositories:

    {
        "type": "git",
        "url": "https://rmvl@bitbucket.org/rmvl/yii2-file-grid-view.git"
    }

запустить команду

    composer require exclusive/yii2-order-api:dev-master




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
