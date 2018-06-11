<?php

namespace rmnvl\yii2FileGridView\src\models;

use rmnvl\yii2FileGridView\src\assets\FileParserAsset;
use rmnvl\yii2FileGridView\src\parsers\ParserFactory;
use yii\data\ArrayDataProvider;
use yii\grid\DataColumn;
use yii\grid\GridView;
use yii\web\View;

/**
 * Class FileGridView
 * @package rmnvl\yii2FileGridView\src\models
 */
class FileGridView extends GridView
{
    const ACTION_COLUMN_CLASS = 'yii\grid\ActionColumn';

    public $fileParser;

    public $filePath;

    public $sort = [];

    public function init()
    {
        if (!$this->filePath) {
            throw new \Exception('FilePath is required');
        }

        $this->fileParser = ParserFactory::create($this->filePath);
        $data = $this->fileParser->parse();

        $this->dataProvider = new ArrayDataProvider(
            [
                'allModels' => $data,
                'sort' => $this->sort
            ]
        );

        parent::init(); // TODO: Change the autogenerated stub


        FileParserAsset::register($this->getView());
        $this->getView()->registerJs('var filePath = "' . $this->filePath . '";', View::POS_HEAD);
    }


    public function run()
    {
        $this->addModalWindow();
        parent::run();
    }

    /**
     * Модальное окно для редактирования
     */
    private function addModalWindow()
    {
        $this->layout .= '<!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Update</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="file-row-update">
            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" id="file-update-row" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </div>';
    }

    /**
     * Creates column objects and initializes them.
     */
    protected function initColumns()
    {
        if (empty($this->columns)) {
            $this->guessColumns();
        }
        foreach ($this->columns as $i => $column) {
            if (is_string($column)) {
                $column = $this->createDataColumn($column);
            } else {
                if ($column['class'] === self::ACTION_COLUMN_CLASS) {
                    if (!isset($column['template'])) {
                        $column['template'] = $this->getDefaultActionTemplate();
                    }
                    if (!isset($column['buttons'])) {
                        $column['buttons'] = $this->getDefaultActionButtons();
                    }
                }
                $column = \Yii::createObject(array_merge([
                    'class' => $this->dataColumnClass ?: DataColumn::className(),
                    'grid' => $this,
                ], $column));
            }
            if (!$column->visible) {
                unset($this->columns[$i]);
                continue;
            }
            $this->columns[$i] = $column;
        }
    }


    /**
     * @return string
     */
    private function getDefaultActionTemplate()
    {
        return '{update} {delete}';
    }

    /**
     * @return array
     */
    private function getDefaultActionButtons()
    {
        return [
            'delete' => function ($url, $model, $key) {
                return "<a href='#' class='delete-row' data-id='" . $key . "'>Delete</a>";
            },
            'update' => function ($url, $model, $key) {
                return "<a href='#'
                                    data-toggle='modal'
                                    data-target='#exampleModal'
                                    class='update-row'
                                    data-id='" . $key . "'>Update</a>";
            }
        ];
    }
}